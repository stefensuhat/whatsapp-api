# WhatsApp Clone API Documentation

## Authentication
### Register User
```
POST /api/register
Content-Type: application/json

{
    "name": "string",
    "email": "string",
    "password": "string"
}
```

### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "string",
    "password": "string"
}

Response:
{
    "token": "string"
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
        "users_count": integer,
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
    "users_count": integer
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
    "users_count": integer
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
const socket = new WebSocket('ws://your-domain/ws');
socket.send(JSON.stringify({
    type: 'join',
    chatroomId: integer
}));
```

### Message Received Event
```javascript
socket.onmessage = (event) => {
    const message = JSON.parse(event.data);
    // Handle new message
};
```

### Chatroom Updated Event
```javascript
// Listen on 'chatrooms' channel for updates
Echo.channel('chatrooms')
    .listen('ChatroomUpdated', (e) => {
        // Handle chatroom update
    });
```
