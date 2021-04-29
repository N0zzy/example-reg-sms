# API
1) форма входа
GET
http://reg-sms.ru/reg

Response in Form
{
	_token
}


2) запрос на регистрацию
POST
http://reg-sms.ru/reg/request

Request 
{
	_token
	name
	mail
	phone
	inn
}

Response
{
    error 
    text
    xxxx
}

Error Response {
	error
	text
	xxxx
}

3) проверка 
POST
http://reg-sms.ru/api/check/company
Request 
{
	_token
	inn
}

Response
{
    "result": {
        "name": ...
        "adddress": ...
    }
}

POST
http://reg-sms.ru/api/check/personal
Request 
{
	_token
    name
	mail
}

Response
{
    "result": {
        "name": ...
        "mail": ...
        "id": ...
    }
}
