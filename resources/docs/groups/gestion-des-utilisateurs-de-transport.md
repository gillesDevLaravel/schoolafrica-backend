# Gestion des Utilisateurs de Transport


## Récupère la liste paginée des utilisateurs de transport.

<small class="badge badge-darkred">requires authentication</small>

Permet de filtrer par type et/ou student_id.
 La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).

> Example request:

```bash
curl -X POST \
    "http://localhost/api/transport-usersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"nbreItems":3,"pageItems":8,"type":"autem","student_id":18}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-usersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "nbreItems": 3,
    "pageItems": 8,
    "type": "autem",
    "student_id": 18
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transport-usersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'nbreItems' => 3,
            'pageItems' => 8,
            'type' => 'autem',
            'student_id' => 18,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transport-usersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transport-usersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transport-usersall"></code></pre>
</div>
<div id="execution-error-POSTapi-transport-usersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transport-usersall"></code></pre>
</div>
<form id="form-POSTapi-transport-usersall" data-method="POST" data-path="api/transport-usersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transport-usersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transport-usersall</code></b>
</p>
<p>
<label id="auth-POSTapi-transport-usersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transport-usersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>student_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="student_id" data-endpoint="POSTapi-transport-usersall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouvel utilisateur de transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transport-users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"transport_id":4,"student_id":7,"type":"ipsam","amount":5870,"reduction":false,"reduction_amount":334089.270402,"reason":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-users"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "transport_id": 4,
    "student_id": 7,
    "type": "ipsam",
    "amount": 5870,
    "reduction": false,
    "reduction_amount": 334089.270402,
    "reason": "omnis"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transport-users',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'transport_id' => 4,
            'student_id' => 7,
            'type' => 'ipsam',
            'amount' => 5870.0,
            'reduction' => false,
            'reduction_amount' => 334089.270402,
            'reason' => 'omnis',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transport-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transport-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transport-users"></code></pre>
</div>
<div id="execution-error-POSTapi-transport-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transport-users"></code></pre>
</div>
<form id="form-POSTapi-transport-users" data-method="POST" data-path="api/transport-users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transport-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transport-users</code></b>
</p>
<p>
<label id="auth-POSTapi-transport-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transport-users" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>transport_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="transport_id" data-endpoint="POSTapi-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>student_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="student_id" data-endpoint="POSTapi-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="amount" data-endpoint="POSTapi-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reduction</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-transport-users" hidden><input type="radio" name="reduction" value="true" data-endpoint="POSTapi-transport-users" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-transport-users" hidden><input type="radio" name="reduction" value="false" data-endpoint="POSTapi-transport-users" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>reduction_amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="reduction_amount" data-endpoint="POSTapi-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-transport-users" data-component="body"  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un utilisateur de transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/transport-users/quidem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transport-users/quidem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/transport-users/quidem',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-transport-users--transport_user-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-transport-users--transport_user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-transport-users--transport_user-"></code></pre>
</div>
<div id="execution-error-GETapi-transport-users--transport_user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-transport-users--transport_user-"></code></pre>
</div>
<form id="form-GETapi-transport-users--transport_user-" data-method="GET" data-path="api/transport-users/{transport_user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-transport-users--transport_user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/transport-users/{transport_user}</code></b>
</p>
<p>
<label id="auth-GETapi-transport-users--transport_user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-transport-users--transport_user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>transport_user</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="transport_user" data-endpoint="GETapi-transport-users--transport_user-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un utilisateur de transport existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/transport-users/ex" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"transport_id":1,"student_id":5,"type":"esse","amount":43,"reduction":false,"reduction_amount":95,"reason":"recusandae"}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-users/ex"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "transport_id": 1,
    "student_id": 5,
    "type": "esse",
    "amount": 43,
    "reduction": false,
    "reduction_amount": 95,
    "reason": "recusandae"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/transport-users/ex',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'transport_id' => 1,
            'student_id' => 5,
            'type' => 'esse',
            'amount' => 43.0,
            'reduction' => false,
            'reduction_amount' => 95.0,
            'reason' => 'recusandae',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-PUTapi-transport-users--transport_user-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-transport-users--transport_user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-transport-users--transport_user-"></code></pre>
</div>
<div id="execution-error-PUTapi-transport-users--transport_user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-transport-users--transport_user-"></code></pre>
</div>
<form id="form-PUTapi-transport-users--transport_user-" data-method="PUT" data-path="api/transport-users/{transport_user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-transport-users--transport_user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/transport-users/{transport_user}</code></b>
</p>
<p>
<label id="auth-PUTapi-transport-users--transport_user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-transport-users--transport_user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>transport_user</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="transport_user" data-endpoint="PUTapi-transport-users--transport_user-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>transport_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="transport_id" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>student_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="student_id" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reduction</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-transport-users--transport_user-" hidden><input type="radio" name="reduction" value="true" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-transport-users--transport_user-" hidden><input type="radio" name="reduction" value="false" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>reduction_amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="reduction_amount" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-transport-users--transport_user-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprime temporairement un ou plusieurs utilisateurs de transport (mise à la corbeille).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transport-users/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[14,9]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-users/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        14,
        9
    ]
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transport-users/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                14,
                9,
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transport-users-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transport-users-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transport-users-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-transport-users-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transport-users-trash"></code></pre>
</div>
<form id="form-POSTapi-transport-users-trash" data-method="POST" data-path="api/transport-users/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transport-users-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transport-users/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-transport-users-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transport-users-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transport-users-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transport-users-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure un ou plusieurs utilisateurs de transport supprimés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transport-users/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,8]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-users/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
        8
    ]
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transport-users/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
                8,
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transport-users-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transport-users-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transport-users-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-transport-users-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transport-users-restore"></code></pre>
</div>
<form id="form-POSTapi-transport-users-restore" data-method="POST" data-path="api/transport-users/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transport-users-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transport-users/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-transport-users-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transport-users-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transport-users-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transport-users-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement un ou plusieurs utilisateurs de transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transport-users/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[19,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transport-users/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        19,
        11
    ]
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transport-users/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                19,
                11,
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transport-users-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transport-users-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transport-users-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-transport-users-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transport-users-delete"></code></pre>
</div>
<form id="form-POSTapi-transport-users-delete" data-method="POST" data-path="api/transport-users/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transport-users-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transport-users/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-transport-users-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transport-users-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transport-users-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transport-users-delete" data-component="body" hidden>
<br>

</p>

</form>



