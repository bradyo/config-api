# Config API Readme

## Endpoint URL Structure

```
/accounts
/accounts/:id
/accounts/current
```

```
/accounts/:id/configs
/accounts/:id/configs/:id
/accounts/:id/configs/:id/schema
/accounts/:id/configs/:id/profiles
/accounts/:id/configs/:id/profiles/:id/versions
/accounts/:id/configs/:id/profiles/:id/versions/:id
/accounts/:id/configs/:id/profiles/:id/versions/:id/consumers
/accounts/:id/configs/:id/profiles/:id/versions/latest
```

```
/accounts/:id/consumers
/accounts/:id/consumers/:id
/accounts/:id/consumers/:id/data
/accounts/:id/consumers/:id/listeners
/accounts/:id/consumers/:id/listeners/:id/messages
```

### Examples:

```
/accounts/1/configs/1/schema
/accounts/1/configs/1/profiles/production/versions/1
/accounts/1/configs/1/profiles/production/versions/2
/accounts/1/configs/1/profiles/staging/versions/1
/accounts/1/consumers/1/profile
/accounts/1/consumers/1/listeners/1/messages
```

## Rest Flows

### Create Config

```bash
curl -u TestClient:token 'http://localhost:8000/configs' \
-X POST -d '{
    "name": "website",
    "schema": {
        "description": "Website Config",
        "type": "object",
        "properties": {
            "aws": {
                "type": "object",
                "required": true,
                "properties": {
                    "accessKeyId": {
                        "type": "string",
                        "required": "true"
                    },
                    "secretAccessKey": {
                        "type": "string",
                        "required": "true"
                    }
                }
            }
        },
        "additionalProperties": false
    }
}'
```

### Create Config Profiles

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/versions' \
-H "Content-Type: application/json" \
-X POST -d '{
    "aws": {
        "accessKeyId": "prod-super-secret-id",
        "secretAccessKey": "prod-super-secret-key"
    }
}'
```
```
201 http://localhost:8000/configs/1/profiles/production/versions/1
```

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/staging/versions' \
-H "Content-Type: application/json" \
-X POST -d '{
    "aws": {
        "access_key_id": "staging-super-secret-id",
        "secret_access_key": "staging-super-secret-key"
    }
}'
```
```
201 http://localhost:8000/configs/1/profiles/staging/versions/1
```

### Update Config Profile (Create New Version)

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/versions' \
-H "Content-Type: application/json" \
-X POST -d '{
    "aws": {
        "access_key_id": "prod-super-secret-id-2",
        "secret_access_key": "prod-super-secret-key-2"
    }
}'
```
```
201 http://localhost:8000/configs/1/profiles/production/versions/2
```


### Get Config Details

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1'
{
    "href": "http://localhost:8000/configs/1",
    "name": "website",
    "created_at": "2015-01-01T00:00:00Z",
    "schema": {
        "href": "http://localhost:8000/configs/1/schema"
    },
    "profiles": [
        "href": "http://localhost:8000/configs/1/profiles",
        "production": {
            "href": "http://localhost:8000/configs/1/profiles/production"
        },
        "staging": {
            "href": "http://localhost:8000/configs/1/profiles/staging"
        }
    ]
}
```

### Get Config Profile Details

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production'
{
    "href": "http://localhost:8000/configs/1/profiles/production",
    "created_at": "2015-01-01T00:00:00Z",
    "updated_at": "2015-01-01T00:00:00Z",
    "data": {
        "href": "http://localhost:8000/configs/1/profiles/production/versions/2/data"
    },
    "versions": {
        "href": "http://localhost:8000/configs/1/profiles/production/versions"
    },
    "consumer_keys": {
        "href": "http://localhost:8000/configs/1/profiles/production/consumer-keys"
    }
    "consumers": {
        "href": "http://localhost:8000/configs/1/profiles/production/consumers"
    }
}
```

### Get Config Profile Versions

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/versions'
{
    "href": "http://localhost:8000/configs/1/profiles/production/versions",
    "total": 2,
    "items": [
        {
            "href": "http://localhost:8000/configs/1/profiles/production/versions/1",
            "created_at": "2015-01-01T00:00:00Z",
            "data": {
                "href": "http://localhost:8000/configs/1/profiles/production/versions/1/data"
            }
        },
        {
            "href": "http://localhost:8000/configs/1/profiles/production/versions/2",
            "created_at": "2015-01-01T00:00:00Z",
            "data": {
                "href": "http://localhost:8000/configs/1/profiles/production/versions/2/data"
            }
        }
    ]
}
```

### Get Config Profile Data

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/data' \
{
    "aws": {
        "access_key_id": "prod-super-secret-id-2",
        "secret_access_key": "prod-super-secret-key-2"
    }
}
```

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/versions/2/data' \
{
    "aws": {
        "access_key_id": "prod-super-secret-id-2",
        "secret_access_key": "prod-super-secret-key-2"
    }
}
```

### Create Consumer Token for Config Profile

```bash
curl -u TestClient:token 'http://localhost:8000/configs/1/profiles/production/consumer-tokens' \
-X POST -d '{
    "name": "ProductionConsumer",
    "token": "2b949d90e83952e5448cf74ff15e291e5ef3af51",
}'
```

### Register a Config Profile Consumer

```bash
curl -u ProductionConsumer:token 'http://localhost:8000/consumers' \
-X POST -d '{
    "host": "server1",
    "ip": "10.0.0.101",
    "profile": {
        "href": "http://localhost:8000/configs/1/profiles/production"
    },
    "listeners": {
        "items": [
            {
                "event": "config-updated",
                "url": "https://10.0.0.101/config-updated-events"
            },
            {
                "event": "config-consumer-added",
                "url": "https://10.0.0.101/config-consumer-added-events"
            },
            {
                "event": "token-revoked",
                "url": "https://10.0.0.101/token-revoked-events"
            }
        ]
    }
}'
```

```bash
curl -u ProductionConsumer:2b949d90e83952e5448cf74ff15e291e5ef3af51 'http://localhost:8000/consumers' \
-X POST -d '{
    "host": "server2",
    "ip": "10.0.0.102",
    "profile": {
        "href": "http://localhost:8000/configs/1/profiles/production"
    }
}'
```


### List Consumers

```bash
curl -u TestClient:token 'http://localhost:8000/consumers' \
{
    "href": "http://localhost:8000/consumers",
    "total": 2,
    "items": [
        {
            "href": "http://localhost:8000/consumers/1"
            "host": "server1",
            "ip": "10.0.0.101",
            "created_at": "2015-01-01T00:00:00Z",
            "profile": {
                "href": "http://localhost:8000/configs/1/profiles/production"
            },
            "listeners": {
                "href": "http://localhost:8000/consumers/1/listeners"
            }
        },
        {
            "href": "http://localhost:8000/consumers/2"
            "host": "server2",
            "ip": "10.0.0.102",
            "created_at": "2015-01-01T00:00:00Z",
            "profile": {
                "href": "http://localhost:8000/configs/2/profiles/production"
            },
            "listeners": {
                "href": "http://localhost:8000/consumers/2/listeners"
            }
        }
    ]
}
```

### List Consumer Listener Messages (Post-Backs)

```bash
curl -u TestClient:token 'http://localhost:8000/consumers/1/listeners/1/messages' \
{
    "href": "http://localhost:8000/consumers/1/listeners/1/messages",
    "total": 1,
    "items": [
        {
            "href": "http://localhost:8000/consumers/1/listeners/1/messages/1",
            "created_at": "2015-01-01T00:00:00Z",
            "delivered_at": "2015-01-01T00:00:00Z",
            "type": "config-updated",
            "payload": {
                "from_version": {
                    "href": "http://localhost:8000/configs/1/profiles/production/versions/1"
                },
                "to_version": {
                    "href": "http://localhost:8000/configs/1/profiles/production/versions/2"
                }
            }
        }
    ]
}
```