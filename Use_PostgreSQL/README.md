Backend
    - API   
      - Authentication
        - login
        - register
        - checkAdmin
        - checkUser
      - User
        - Shop
          - listCart
          - listProduct
          - buyProduct
          - addProduct
          - deleteProduct
          - showWallet
          - checkVIP
        - Profile
          - updateUser
        - Wallet
          - recharge
          - transf
          - getVIP
          - unVIP
          - checkVIP
      - Admin
        - manageProduct
          - addProduct
          - removeProduct
          - listProduct
        - manageUser
          - listUser
          - deleteUser


- Analyze API
  - Authentication
      - Login 
        - URL: api/authentication.php
    		- Method: POST
    		- Request: {
    			"action": "login",
    			"email": "<email>",
    			"password": "<password>"
    		}
    		- Response: {
    			"status": 1 (1: success, 2 failed),
    			"msg": "Error ???"
    		}
      - Logout
        - URL: api/authentication.php
    		- Method: POST
    		- Request: {
    			"action": "logout"
    		}
    		- Response: {
    			"status": 1 (1: success, 2 failed),
    			"msg": "Error ???"
    		}




Tham khao: https://gokisoft.com/share-code-huong-dan-tao-du-an-api-trong-php-server--client-lap-trinh-phpmysql.html