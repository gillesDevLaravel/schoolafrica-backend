# Package


## Lister les packages

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/packages" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/packages"
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
    'http://localhost/api/packages',
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
<div id="execution-results-GETapi-packages" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-packages"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-packages"></code></pre>
</div>
<div id="execution-error-GETapi-packages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-packages"></code></pre>
</div>
<form id="form-GETapi-packages" data-method="GET" data-path="api/packages" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-packages', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/packages</code></b>
</p>
<p>
<label id="auth-GETapi-packages" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-packages" data-component="header"></label>
</p>
</form>


## Ajouter un package

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/packages" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"recusandae","level":"ea","price":"aut","duration":"quis","description":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/api/packages"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "recusandae",
    "level": "ea",
    "price": "aut",
    "duration": "quis",
    "description": "ut"
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
    'http://localhost/api/packages',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'recusandae',
            'level' => 'ea',
            'price' => 'aut',
            'duration' => 'quis',
            'description' => 'ut',
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
<div id="execution-results-POSTapi-packages" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-packages"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-packages"></code></pre>
</div>
<div id="execution-error-POSTapi-packages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-packages"></code></pre>
</div>
<form id="form-POSTapi-packages" data-method="POST" data-path="api/packages" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-packages', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/packages</code></b>
</p>
<p>
<label id="auth-POSTapi-packages" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-packages" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-packages" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>level</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="level" data-endpoint="POSTapi-packages" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="price" data-endpoint="POSTapi-packages" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="duration" data-endpoint="POSTapi-packages" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-packages" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;un package

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/packages/non" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/packages/non"
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
    'http://localhost/api/packages/non',
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
<div id="execution-results-GETapi-packages--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-packages--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-packages--id-"></code></pre>
</div>
<div id="execution-error-GETapi-packages--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-packages--id-"></code></pre>
</div>
<form id="form-GETapi-packages--id-" data-method="GET" data-path="api/packages/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-packages--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/packages/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-packages--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-packages--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-packages--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un package

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/packages/molestiae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"inventore","level":"distinctio","price":"dolores","duration":"aut","description":"maiores"}'

```

```javascript
const url = new URL(
    "http://localhost/api/packages/molestiae"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "inventore",
    "level": "distinctio",
    "price": "dolores",
    "duration": "aut",
    "description": "maiores"
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
    'http://localhost/api/packages/molestiae',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'inventore',
            'level' => 'distinctio',
            'price' => 'dolores',
            'duration' => 'aut',
            'description' => 'maiores',
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
<div id="execution-results-PUTapi-packages--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-packages--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-packages--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-packages--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-packages--id-"></code></pre>
</div>
<form id="form-PUTapi-packages--id-" data-method="PUT" data-path="api/packages/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-packages--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/packages/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-packages--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-packages--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-packages--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-packages--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>level</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="level" data-endpoint="PUTapi-packages--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="price" data-endpoint="PUTapi-packages--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="duration" data-endpoint="PUTapi-packages--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-packages--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Supprimer un package

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/packages/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/packages/sint"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/packages/sint',
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
<div id="execution-results-DELETEapi-packages--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-packages--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-packages--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-packages--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-packages--id-"></code></pre>
</div>
<form id="form-DELETEapi-packages--id-" data-method="DELETE" data-path="api/packages/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-packages--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/packages/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-packages--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-packages--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-packages--id-" data-component="url" required  hidden>
<br>

</p>
</form>



