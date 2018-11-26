# Project api methods

1. POST /api/v1/register
   # required body
   [
        "password": "test",
        "firstname": "firstname",
        "lastname": "lastname",
        "age": "23",
        "nickname": "test"
   ]
   
2. POST /api/v1/login
   # required body
   [
        "password": "test",
        "nickname": "test"
   ]
   
3. GET /api/v1/track?source_label=pageHitEvent
