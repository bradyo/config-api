
Endpoints
---------

/accounts
/accounts/:id

/accounts/:id/configs
/accounts/:id/configs/:id
/accounts/:id/configs/:id/schema

/accounts/:id/
/accounts/:id/configs/:id/schema/profiles/:id

/accounts/:id/configs/:id/schema/profiles/:id/consumers

/accounts/:id/events

/accounts/:id/api-keys

/accounts/:id/consumers


Formats
-------

GET /accounts/1/profiles

```
{
    "total": 3,
    "profiles": [
        {
            "id": "development",
            "href": "https://config.website.com/accounts/1/profiles/development",
            "consumers": [
                {
                    "id": 123,
                    "url": "https://localhost/accounts/1/consumers/1",
                }
            ],
            "configs": [
                {
                    "id": "1.0.0",
                    "href": "https://config.website.com/accounts/1/profiles/development/configs/1",
                    "createdAt": "2015-01-01T22:00:00Z",
                    "schema": {
                        "dataUrl": "https://s3/schemas-1.json"
                    }
                }
            ]
        },
        {
            "id": 2,
            "href": "https://config.website.com/accounts/1/configs/1/profiles/staging",
            "name": "staging",
            "dataUrl": "https://s3/profiles-2.json",
            "consumers": [
                {
                    "id": 2,
                    "href": "https://localhost/accounts/1/consumers/2",
                }
            ]
        },
        {
            "id": 3,
            "href": "https://config.website.com/accounts/1/configs/1/profiles/production",
            "name": "production",
            "dataUrl": "https://s3/profiles-3.json",
            "consumers": [
                {
                    "id": 3,
                    "href": "https://config.website.com/accounts/1/consumers/3",
                },
                {
                    "id": 4,
                    "href": "https://config.website.com/accounts/1/consumers/4",
                }
            ]
        }
    ]
}
```

GET /accounts/1/consumers/1

```json
{
    "id": 1,
    "createdAt": "2015-01-01T22:00:00Z",
    "host": "www.website.local",
    "ip": "10.0.0.1",
    "profile": {
        "id": 1,
        "href": "https://localhost/accounts/1/configs/1/profiles/1",
    },
    "postBacks": [
        {
            "events": ["updated", "deleted"],
            "postBackUrl": "https://www.website.local/post-backs/config-events"
        }
    ]
}
```

