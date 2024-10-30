import subprocess, shlex, json
from mysql.connector import (connection)
from devtools import debug
from contextlib import suppress
from mysql.connector.errors import IntegrityError


def get_customer_groups(cnx):
  cursor = cnx.cursor(buffered=True)

  query = "SELECT * FROM customer_group WHERE customer_group_id > %s;"
  cursor.execute(query, (0,))

  for row in cursor:
    yield row

  cursor.close()


def fill_salesgroup(cnx, customer_group):
  cursor = cnx.cursor()

  add_sales_group = """
    INSERT INTO salesgroup_salesgroup 
    (salesgroup_id, name, sales_group_code)
    VALUES (%s, %s, %s);
    """

  cursor.execute(
    add_sales_group,
    (customer_group[0], customer_group[1], customer_group[1])
  )

  cnx.commit()
  cursor.close()


def get_attribute_id(cnx):
  cursor = cnx.cursor(buffered=True)
  sales_group_attribute_id_sql = """
  SELECT eav_attribute.attribute_id FROM eav_attribute
    LEFT JOIN customer_eav_attribute_website AS scope_table
      ON eav_attribute.attribute_id = scope_table.attribute_id AND scope_table.website_id =1 
    WHERE (eav_attribute.attribute_code='sales_group') AND (entity_type_id = 1);
  """

  cursor.execute(sales_group_attribute_id_sql)
  attribute_id = list(cursor)[0][0]
  cursor.close()
  return attribute_id


def get_customers(cnx):
  cursor = cnx.cursor(buffered=True)
  limit = 100
  page = 0

  while True:
    query = """SELECT entity_id, group_id, email 
      FROM customer_entity
      WHERE group_id IS NOT NULL
      LIMIT %s
      OFFSET %s;
    """
    cursor.execute(query, (limit, page*limit))
    page += 1
    if not cursor.rowcount:
      break

    for row in cursor:
      yield row

  cursor.close()

def update_customer(cnx, attribute_id, customer):
  (entity_id, group_id, _) = customer
  cursor = cnx.cursor()
  sales_group_attribute_id_sql = """
  INSERT  INTO `customer_entity_int` (`entity_id`,`attribute_id`,`value`)
   VALUES (%s, %s, %s)
   ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)
  """

  cursor.execute(sales_group_attribute_id_sql, (entity_id, attribute_id, group_id))
  cnx.commit()

  cursor.close()

def get_params():
  import argparse, os

  def dir_path(string):
    if os.path.isdir(string):
        return string
    else:
        raise NotADirectoryError(string)

  parser = argparse.ArgumentParser(description="Run migration")
  parser.add_argument("root", type=dir_path, help="Magento root")

  return parser.parse_args()

def get_config(root):
  env_file = f"{root}/app/etc/env.php"
  command = f"""php -r 'echo json_encode(include "{env_file}");'"""
  result = subprocess.run(shlex.split(command), stdout=subprocess.PIPE)
  if result.returncode != 0:
    raise Exception("Error in command {command}")

  return json.loads(result.stdout)

def migrate(db):
  cnx = connection.MySQLConnection(
      user=db["username"],
      password=db["password"],
      host=db["host"],
      database=db["dbname"]
  )

  customer_groups = get_customer_groups(cnx)

  for customer_group in customer_groups:
    debug(customer_group)
    with suppress(IntegrityError):
      fill_salesgroup(cnx, customer_group)

  attribute_id = get_attribute_id(cnx)
  debug(attribute_id)

  customers = get_customers(cnx)
  for customer in customers:
    debug(customer)
    update_customer(cnx, attribute_id, customer)

  cnx.close()


if __name__ == "__main__":
  arg = get_params()
  config = get_config(arg.root)
  db_config = config['db']['connection']['default']
  migrate(db_config)