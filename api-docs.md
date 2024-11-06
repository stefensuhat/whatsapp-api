# WhatsApp Clone API Documentation

## Authentication


### Login
```
POST /api/login
Content-Type: application/json

{
    "username": "string",
    "password": "string"
}

Response:
{
    "token": "string"
    "user": {
        "id": "string",
        "username": "string",
        "created_at": "string",
        "updated_at": "string"
    }
}
```

## Chatrooms
### List Chatrooms
```
GET /api/chatrooms
Authorization: Bearer {token}

Response:
[
    {
        "id": integer,
        "name": "string",
        "max_members": integer,
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
]
```

### Create Chatroom
```
POST /api/chatrooms
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "string",
    "max_members": integer
}

Response:
{
    "id": integer,
    "name": "string",
    "max_members": integer,
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

### Join Chatroom
```
POST /api/chatrooms/{id}/join
Authorization: Bearer {token}

Response:
{
    "id": integer,
    "name": "string",
    "max_members": integer,
}
```

### Leave Chatroom
```
POST /api/chatrooms/{id}/leave
Authorization: Bearer {token}

Response:
{
    "id": integer,
    "name": "string",
    "max_members": integer,
}
```

## Messages
### List Messages
```
GET /api/chatrooms/{id}/messages
Authorization: Bearer {token}

Response:
{
    "data": [
        {
            "id": integer,
            "content": "string",
            "attachment_path": "string|null",
            "attachment_type": "string|null",
            "user": {
                "id": integer,
                "name": "string"
            },
            "created_at": "timestamp"
        }
    ],
    "meta": {
        "current_page": integer,
        "last_page": integer,
        "per_page": integer,
        "total": integer
    }
}
```

### Send Message
```
POST /api/chatrooms/{id}/messages
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "content": "string|null",
    "attachment": "file|null"
}

Response:
{
    "id": integer,
    "content": "string|null",
    "attachment_path": "string|null",
    "attachment_type": "string|null",
    "user_id": integer,
    "created_at": "timestamp"
}
```

## WebSocket Events

### Connect to Chatroom
```javascript
const echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    // authEndpoint: `http://localhost:8000/broadcasting/auth`,
    authorizer: (channel: { name: any }, _options: any) => {
        return {
            authorize: (socketId: any, callback: (arg0: boolean, arg1: AxiosResponse<any, any>) => void) => {
                http
                    .post('/broadcasting/auth', {
                        socket_id: socketId,
                        channel_name: channel.name,
                    })
                    .then((response) => {
                        callback(false, response)
                    })
                    .catch((error) => {
                        callback(true, error)
                    })
            },
        }
    },
})
```

### Chatroom Updated Event
```javascript
// Listen on 'chatrooms' channel for updates
Echo.channel('chatroom')
    .listen('MessageSent', (e) => {
        refetch()
    });
```
