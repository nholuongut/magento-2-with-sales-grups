import re

def convert_customer_group_name(name):
      m = re.match(r"\w+(\s\w+)\s?.*", name)
      m.grop()


print(convert_customer_group_name("aaa sss ddd"))