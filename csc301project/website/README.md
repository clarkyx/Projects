East Scaraborough Storefront
============================

```
controllers
-----------
    account             the controller for adding/editing/removing clients and
                        users
    ---------------------------------------------------------------------------
        login           login to the page and allow access to certain functions
                        depending on the access of the user that logged in

        logout          logout and destory session

        new_client      adds a new client into the database by using the
                        client_model

        new_user        adds a new user into the database by using the
                        user_model
    ---------------------------------------------------------------------------

    main                the main controller for interacting with the main view
                        of the calendar page
    ---------------------------------------------------------------------------
        

models
------
    user
    ---------------------------------------------------------------------------


    user_model          get get the user row in order to update manually
    ---------------------------------------------------------------------------
        get_from_name
        get_from_id
        get_from_email
        insert
        update_password
views
-----
    account/main
```
