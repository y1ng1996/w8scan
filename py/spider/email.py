# Name:E-mail搜索
# Descript:搜索出网站的e-mail，并且能够去重复
def run(url='',body=''):
    pattern = re.compile(r'([\w-]+@[\w-]+\.[\w-]+)+')
    email_list = re.findall(pattern, body)
    if (email_list):
        for email in email_list:
            print "[e-mail] find! " + email
            report.add_set("E-mail",email)
        return True
    return False