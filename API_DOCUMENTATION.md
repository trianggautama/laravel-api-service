# API Documentation - Posts Resource

## Base URL
```
http://127.0.0.1:8002/api
```

## Authentication
All API endpoints require Bearer token authentication. The token should be the user's API key.

**Header:**
```
Authorization: Bearer {user_api_key}
Content-Type: application/json
```

## Endpoints

### 1. Get All Posts (User's Posts Only)
**GET** `/posts`

Returns all posts belonging to the authenticated user.

**Example Request:**
```bash
curl -X GET "http://127.0.0.1:8002/api/posts" \
  -H "Authorization: Bearer API_IvTWJLWVHByuZxzAbyTn9frB1HtPPvOX" \
  -H "Content-Type: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 2,
      "title": "Second Post",
      "body": "Lorem Ipsum is simply dummy text...",
      "author": {
        "id": 2,
        "name": "Tri Angga Utama",
        "email": "trianggautama@gmail.com"
      },
      "created_at": "2025-11-13T12:42:12.000000Z",
      "updated_at": "2025-11-13T12:42:12.000000Z"
    }
  ],
  "message": "Posts retrieved successfully"
}
```

### 2. Create Post
**POST** `/posts`

Creates a new post for the authenticated user.

**Request Body:**
```json
{
  "title": "Post Title",
  "body": "Post content"
}
```

**Example Request:**
```bash
curl -X POST "http://127.0.0.1:8002/api/posts" \
  -H "Authorization: Bearer API_IvTWJLWVHByuZxzAbyTn9frB1HtPPvOX" \
  -H "Content-Type: application/json" \
  -d '{"title": "API Test Post", "body": "This is a test post created via API."}'
```

**Example Response:**
```json
{
  "success": true,
  "data": {
    "id": 5,
    "title": "API Test Post",
    "body": "This is a test post created via API.",
    "author": {
      "id": 2,
      "name": "Tri Angga Utama",
      "email": "trianggautama@gmail.com"
    },
    "created_at": "2025-11-13T13:02:41.000000Z",
    "updated_at": "2025-11-13T13:02:41.000000Z"
  },
  "message": "Post created successfully"
}
```

### 3. Get Single Post
**GET** `/posts/{id}`

Returns a specific post if it belongs to the authenticated user.

**Example Request:**
```bash
curl -X GET "http://127.0.0.1:8002/api/posts/5" \
  -H "Authorization: Bearer API_IvTWJLWVHByuZxzAbyTn9frB1HtPPvOX" \
  -H "Content-Type: application/json"
```

### 4. Update Post
**PUT** `/posts/{id}`

Updates a post if it belongs to the authenticated user.

**Request Body:**
```json
{
  "title": "Updated Title",
  "body": "Updated content"
}
```

**Example Request:**
```bash
curl -X PUT "http://127.0.0.1:8002/api/posts/5" \
  -H "Authorization: Bearer API_IvTWJLWVHByuZxzAbyTn9frB1HtPPvOX" \
  -H "Content-Type: application/json" \
  -d '{"title": "Updated API Test Post", "body": "This post has been updated."}'
```

### 5. Delete Post
**DELETE** `/posts/{id}`

Deletes a post if it belongs to the authenticated user.

**Example Request:**
```bash
curl -X DELETE "http://127.0.0.1:8002/api/posts/5" \
  -H "Authorization: Bearer API_IvTWJLWVHByuZxzAbyTn9frB1HtPPvOX" \
  -H "Content-Type: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Post deleted successfully"
}
```

## Error Responses

### 401 Unauthorized
```json
{
  "error": "Unauthorized",
  "message": "Bearer token required"
}
```

### 401 Invalid API Key
```json
{
  "error": "Unauthorized",
  "message": "Invalid API key"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "error": "Forbidden",
  "message": "You can only view your own posts"
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "body": ["The body field is required."]
  }
}
```

## Security Features

1. **Bearer Token Authentication**: All requests require a valid API key
2. **User Isolation**: Users can only access their own posts
3. **Input Validation**: All inputs are validated before processing
4. **Proper HTTP Status Codes**: Appropriate status codes for different scenarios

## Notes

- All timestamps are in UTC format
- Posts are returned in reverse chronological order (newest first)
- The API key can be obtained from the user's profile in the web interface
- Each user can regenerate their API key from the profile page
