# Rentals / Locations

Gestion des locations

## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/rentalsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"article_id":4,"user_id":20,"start_date":"2025-11-22T14:46:52+0000","end_date":"2025-11-22T14:46:52+0000","filter_value":"accusantium","nbreItems":5,"pageItems":7}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentalsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "article_id": 4,
    "user_id": 20,
    "start_date": "2025-11-22T14:46:52+0000",
    "end_date": "2025-11-22T14:46:52+0000",
    "filter_value": "accusantium",
    "nbreItems": 5,
    "pageItems": 7
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
    'http://localhost/api/rentalsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'article_id' => 4,
            'user_id' => 20,
            'start_date' => '2025-11-22T14:46:52+0000',
            'end_date' => '2025-11-22T14:46:52+0000',
            'filter_value' => 'accusantium',
            'nbreItems' => 5,
            'pageItems' => 7,
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
<div id="execution-results-POSTapi-rentalsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-rentalsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-rentalsall"></code></pre>
</div>
<div id="execution-error-POSTapi-rentalsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-rentalsall"></code></pre>
</div>
<form id="form-POSTapi-rentalsall" data-method="POST" data-path="api/rentalsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-rentalsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/rentalsall</code></b>
</p>
<p>
<label id="auth-POSTapi-rentalsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-rentalsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>article_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="article_id" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-rentalsall" data-component="body"  hidden>
<br>

</p>

</form>


## Show the form for creating a new resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/rentals" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":2,"article_id":10,"description":"laborum","reason":"rerum","exit_quantity":15,"exit_date":"2025-11-22T14:46:52+0000","exit_condition":"ullam","exit_image":"suscipit","entry_quantity":13,"entry_date":"2025-11-22T14:46:52+0000","entry_condition":"quo","entry_image":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentals"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 2,
    "article_id": 10,
    "description": "laborum",
    "reason": "rerum",
    "exit_quantity": 15,
    "exit_date": "2025-11-22T14:46:52+0000",
    "exit_condition": "ullam",
    "exit_image": "suscipit",
    "entry_quantity": 13,
    "entry_date": "2025-11-22T14:46:52+0000",
    "entry_condition": "quo",
    "entry_image": "qui"
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
    'http://localhost/api/rentals',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'user_id' => 2,
            'article_id' => 10,
            'description' => 'laborum',
            'reason' => 'rerum',
            'exit_quantity' => 15,
            'exit_date' => '2025-11-22T14:46:52+0000',
            'exit_condition' => 'ullam',
            'exit_image' => 'suscipit',
            'entry_quantity' => 13,
            'entry_date' => '2025-11-22T14:46:52+0000',
            'entry_condition' => 'quo',
            'entry_image' => 'qui',
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
<div id="execution-results-POSTapi-rentals" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-rentals"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-rentals"></code></pre>
</div>
<div id="execution-error-POSTapi-rentals" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-rentals"></code></pre>
</div>
<form id="form-POSTapi-rentals" data-method="POST" data-path="api/rentals" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-rentals', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/rentals</code></b>
</p>
<p>
<label id="auth-POSTapi-rentals" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-rentals" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="article_id" data-endpoint="POSTapi-rentals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exit_quantity</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="exit_quantity" data-endpoint="POSTapi-rentals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>exit_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_date" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>exit_condition</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_condition" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exit_image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_image" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="entry_quantity" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_date" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>entry_condition</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_condition" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_image" data-endpoint="POSTapi-rentals" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/rentals/magnam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/rentals/magnam"
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
    'http://localhost/api/rentals/magnam',
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
<div id="execution-results-GETapi-rentals--rental-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-rentals--rental-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-rentals--rental-"></code></pre>
</div>
<div id="execution-error-GETapi-rentals--rental-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-rentals--rental-"></code></pre>
</div>
<form id="form-GETapi-rentals--rental-" data-method="GET" data-path="api/rentals/{rental}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-rentals--rental-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/rentals/{rental}</code></b>
</p>
<p>
<label id="auth-GETapi-rentals--rental-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-rentals--rental-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>rental</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="rental" data-endpoint="GETapi-rentals--rental-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/rentals/laboriosam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":7,"article_id":14,"description":"vel","reason":"dolorum","exit_quantity":18,"exit_date":"2025-11-22T14:46:53+0000","exit_condition":"ipsa","exit_image":"aut","entry_quantity":13,"entry_date":"2025-11-22T14:46:53+0000","entry_condition":"aut","entry_image":"autem","return_quantity":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentals/laboriosam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 7,
    "article_id": 14,
    "description": "vel",
    "reason": "dolorum",
    "exit_quantity": 18,
    "exit_date": "2025-11-22T14:46:53+0000",
    "exit_condition": "ipsa",
    "exit_image": "aut",
    "entry_quantity": 13,
    "entry_date": "2025-11-22T14:46:53+0000",
    "entry_condition": "aut",
    "entry_image": "autem",
    "return_quantity": 11
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
    'http://localhost/api/rentals/laboriosam',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'user_id' => 7,
            'article_id' => 14,
            'description' => 'vel',
            'reason' => 'dolorum',
            'exit_quantity' => 18,
            'exit_date' => '2025-11-22T14:46:53+0000',
            'exit_condition' => 'ipsa',
            'exit_image' => 'aut',
            'entry_quantity' => 13,
            'entry_date' => '2025-11-22T14:46:53+0000',
            'entry_condition' => 'aut',
            'entry_image' => 'autem',
            'return_quantity' => 11,
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
<div id="execution-results-PUTapi-rentals--rental-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-rentals--rental-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-rentals--rental-"></code></pre>
</div>
<div id="execution-error-PUTapi-rentals--rental-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-rentals--rental-"></code></pre>
</div>
<form id="form-PUTapi-rentals--rental-" data-method="PUT" data-path="api/rentals/{rental}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-rentals--rental-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/rentals/{rental}</code></b>
</p>
<p>
<label id="auth-PUTapi-rentals--rental-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-rentals--rental-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>rental</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="rental" data-endpoint="PUTapi-rentals--rental-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="article_id" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exit_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="exit_quantity" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exit_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_date" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>exit_condition</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_condition" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exit_image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exit_image" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="entry_quantity" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_date" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>entry_condition</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_condition" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>entry_image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entry_image" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>return_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="return_quantity" data-endpoint="PUTapi-rentals--rental-" data-component="body"  hidden>
<br>

</p>

</form>


## Fonction pour le multiple archivage des locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/rentals/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[3,18]}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentals/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        3,
        18
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
    'http://localhost/api/rentals/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                3,
                18,
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
<div id="execution-results-POSTapi-rentals-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-rentals-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-rentals-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-rentals-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-rentals-trash"></code></pre>
</div>
<form id="form-POSTapi-rentals-trash" data-method="POST" data-path="api/rentals/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-rentals-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/rentals/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-rentals-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-rentals-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-rentals-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-rentals-trash" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de restauration multiples des locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/rentals/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[5,2]}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentals/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        5,
        2
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
    'http://localhost/api/rentals/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                5,
                2,
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
<div id="execution-results-POSTapi-rentals-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-rentals-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-rentals-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-rentals-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-rentals-restore"></code></pre>
</div>
<form id="form-POSTapi-rentals-restore" data-method="POST" data-path="api/rentals/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-rentals-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/rentals/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-rentals-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-rentals-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-rentals-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-rentals-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/rentals/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[5,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/rentals/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        5,
        5
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
    'http://localhost/api/rentals/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                5,
                5,
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
<div id="execution-results-POSTapi-rentals-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-rentals-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-rentals-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-rentals-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-rentals-delete"></code></pre>
</div>
<form id="form-POSTapi-rentals-delete" data-method="POST" data-path="api/rentals/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-rentals-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/rentals/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-rentals-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-rentals-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-rentals-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-rentals-delete" data-component="body" hidden>
<br>

</p>

</form>



