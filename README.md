To try this web app, clone this folder, go to the directory containing file .yml, open terminal and run this command:
> docker compose up

Access to website at: http://localhost:8000 , to phpmyadmin: http://localhost:8080 

Account for phpadmin: nbp1/passMySQL

Account for NBP fruit shop:
    + Admin: admin/admin123
    + User: naruto/12345
    + You can register to get account for user

Functions:
- User
    + Login (Capcha)
    + Register
    + Logout
    + Recharge money with phone card
    + Transfer money to other users
    + Update profile: Name, Avatar, Email, Password,...
    + Buy an product/ Buy all product in cart
    + Add product to cart
    + Remove one/all product from cart
    + VIP: discount 30%, subscribe, unsubscribe

- Admin
    + Login/ Logout
    + Manage account: view, delete account
    + Manage product: view, add, delete product
