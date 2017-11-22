# 1password php api (unofficial)

## features

    create        Create a new object in your account.
    
        document    Upload a document.
        item        Upload a new item to the 1Password server.
        vault       Create a new vault on the 1Password server.
    
    delete        Delete an object in your account.
    
        user    Deletes a user from your 1Password account.
    
    encode        Encodes item JSON before uploading using op create item
    
    get           Get the details of an object in your account.
    
        account     Get get account attributes.
        document    Download a document.
        item        Get item details.
        template    Get item template.
        totp        Get time-based one-time password (TOTP).
        user        Get user attributes.
        vault       Get vault attributes.
    
    list          List objects in your account.
    
        documents    Get a list of documents.
        events       Get audit events.
        groups       Get a list of groups.
        items        Get a list of items.
        templates    Get a list of templates.
        users        Get a list of users.
        vaults       Get a list of vaults.
    
    reactivate    Re-activates a suspended user.
    
    signin        Sign in to the 1Password service and obtain a session.
    
    signout       Log out of 1Password by removing or invalidating a session.
    
    suspend       Suspends a user.
    
    update        Check for new version.
