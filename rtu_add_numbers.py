import requests
import json
import xmltodict
import pprint
import csv
import time
import random
def reaad_file_access(var_login, var_password, Var_address, var_port):
    file = open('access/bd_access', 'r')
    try:
        #lines = {}
        lines = file.readlines()
        print(lines)
        index_len = len(lines)
        #print(index_len)
        icount = 0
        for i in lines:
            icount=icount+1
            #if (icount %2 != 0):
            if (i[i.find('login') : i.find(':')] == 'login'):
                #print(f"login index {icount}")
                var_login = i[i.find(':')+2 : i.find('\n')]
                #print(var_login)
            elif (i[i.find('pass') : i.find(':')] == 'pass'):
                #print(f"password  index {icount}")
                var_password = i[i.find(':')+2 : i.find('\n')]
                #print(var_password)
            elif (i[i.find('address') : i.find(':')] == 'address'):
                var_address = i[i.find(':')+2 : i.find('\n')]
            elif (i[i.find('port') : i.find(':')] == 'port'):
                var_port = i[i.find(':')+2 : i.find('\n')]
    finally:
        file.close()
    return var_login, var_password, var_address, var_port

def import_numbers():
    reader = csv.reader(open('phones_test.csv', encoding="utf8"))
    result = {}
    for row in reader:
        key = row[0]
        if key in result:
            # implement your duplicate row handling here
            pass
        result[key] = row[1:]
    #print(result)
    #reader.close()
    return result
def gen_password():
    chars = '+-*!&$#?=@abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    number_col = 1
    length = 15
    for n in range(number_col):
        user_password =''
        for i in range(length):
            user_password += random.choice(chars)
        #print(user_password)
        return user_password
login = ""
password = ""
address = ""
port = ""
tel_number = ""
tel_name = ""
tel_protocol = ""
mac_address = ""
ip_address = ""
login, password, ip_address, port = reaad_file_access(login, password, address, port)
number = "4000"
requests.packages.urllib3.disable_warnings() # Ignore warnings
result_number = import_numbers()
for key, value in result_number.items():
    #print(key)
    #print(value[0])
    #print(value[3])
    tel_number = key
    tel_name = value[0].replace(' ','_')
    mac_address = value[1]
    tel_protocol = value[3]
    user_password = gen_password()
    headers = {"Content-Type": "text/xml"}
    response = ""
    data = ""
    datas = ""
    datas = f"""<?xml version='1.0' encoding='utf-8'?>
    <commands>
    <authorize>
        <login>{login}</login>
        <password>{password}</password>
        <domain></domain>
    </authorize>

    <command name="Create" table="User">
    
        <item>
            <domain>ROOT</domain>
            <user>{tel_number}</user>
            <id>{tel_number}</id>
                <user_caller_id>{tel_number}</user_caller_id>
            <password>{user_password}</password>
            <web_login>{tel_number}</web_login>
            <subscriber>{tel_number}</subscriber>
            <user_terminals>
            <user_terminal>
            <terminal_id>0</terminal_id>
            <login>{tel_number}</login>
            <password>{user_password}</password>
            <terminal_type>Registerable</terminal_type>
            <ttl>120</ttl>
            <terminal_kind>GenericSIPTerminal</terminal_kind>
            <profile>1.SIP.UDP.INFO.STANDART</profile>
            <rtu_client_type>Null</rtu_client_type>
            <proxy_balancer_mode>OwnProxy</proxy_balancer_mode>
            </user_terminal>
            <user_terminal>
            <terminal_id>1</terminal_id>
            <login>Num{tel_number}SoftFone</login>
            <password>{user_password}</password>
            <terminal_type>Registerable</terminal_type>
            <ttl>120</ttl>
            <terminal_kind>GenericSIPTerminal</terminal_kind>
            <behind_gateway></behind_gateway>
            <profile>WebSoftphone</profile>
            <rtu_client_type>Null</rtu_client_type>
            <selected_balancing_group>
            </selected_balancing_group>
            <proxy_balancer_mode>OwnProxy</proxy_balancer_mode>
            </user_terminal>
            </user_terminals>
            <packages>
            <package>NoBarring</package>
            </packages>
        </item>
    </command>
    </commands>"""
    #print(f"{address} : {port}")
    address = f'https://{ip_address}:{port}/mobile_request/get.aspx?admin'
    response  = requests.post(address, verify=False, data=datas, headers=headers)
    data = response.content.decode('utf-8')
    #json_data = json.loads(data)
    print(data)
    #pp = pprint.PrettyPrinter(indent=4) 
    #dict_json_data = (json.dumps(xmltodict.parse(data)))
    #rtu_dict_data = xmltodict.parse(data)
    #print(r.status_code)
    #print(dict_json_data)
    # print(rtu_dict_data)
    # for i1 in rtu_dict_data.values():
    #     #print(i1)
    #     for i2 in i1.values():
    #         #print(i2)
    #         for i3 in i2.values():
    #             rtu_dict_data = i3
    #print(f"{rtu_dict_data['id']} {rtu_dict_data['user_caller_id']}")
    #
    time.sleep(2)