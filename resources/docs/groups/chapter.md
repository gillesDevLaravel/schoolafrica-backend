# Chapter


## Afficher la liste des chapitres

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/chaptersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":2,"idSection":8,"idProgression":5,"idModule":2,"pageItems":12,"nbreItems":12,"filter_value":"iure"}'

```

```javascript
const url = new URL(
    "http://localhost/api/chaptersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 2,
    "idSection": 8,
    "idProgression": 5,
    "idModule": 2,
    "pageItems": 12,
    "nbreItems": 12,
    "filter_value": "iure"
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
    'http://localhost/api/chaptersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 2,
            'idSection' => 8,
            'idProgression' => 5,
            'idModule' => 2,
            'pageItems' => 12,
            'nbreItems' => 12,
            'filter_value' => 'iure',
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
<div id="execution-results-POSTapi-chaptersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-chaptersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-chaptersall"></code></pre>
</div>
<div id="execution-error-POSTapi-chaptersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-chaptersall"></code></pre>
</div>
<form id="form-POSTapi-chaptersall" data-method="POST" data-path="api/chaptersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-chaptersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/chaptersall</code></b>
</p>
<p>
<label id="auth-POSTapi-chaptersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-chaptersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idProgression</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idProgression" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idModule</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idModule" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-chaptersall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/chapters/odio" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/chapters/odio"
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
    'http://localhost/api/chapters/odio',
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
<div id="execution-results-GETapi-chapters--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-chapters--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-chapters--id-"></code></pre>
</div>
<div id="execution-error-GETapi-chapters--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-chapters--id-"></code></pre>
</div>
<form id="form-GETapi-chapters--id-" data-method="GET" data-path="api/chapters/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-chapters--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/chapters/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-chapters--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-chapters--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-chapters--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un chapitre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/chapters" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"minima","description":"reprehenderit","idModule":6}'

```

```javascript
const url = new URL(
    "http://localhost/api/chapters"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "minima",
    "description": "reprehenderit",
    "idModule": 6
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
    'http://localhost/api/chapters',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'minima',
            'description' => 'reprehenderit',
            'idModule' => 6,
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
<div id="execution-results-POSTapi-chapters" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-chapters"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-chapters"></code></pre>
</div>
<div id="execution-error-POSTapi-chapters" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-chapters"></code></pre>
</div>
<form id="form-POSTapi-chapters" data-method="POST" data-path="api/chapters" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-chapters', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/chapters</code></b>
</p>
<p>
<label id="auth-POSTapi-chapters" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-chapters" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-chapters" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-chapters" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idModule</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idModule" data-endpoint="POSTapi-chapters" data-component="body" required  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/chapters/numquam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"ab","description":"quia","idModule":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/chapters/numquam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ab",
    "description": "quia",
    "idModule": 1
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
    'http://localhost/api/chapters/numquam',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'ab',
            'description' => 'quia',
            'idModule' => 1,
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
<div id="execution-results-PUTapi-chapters--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-chapters--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-chapters--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-chapters--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-chapters--id-"></code></pre>
</div>
<form id="form-PUTapi-chapters--id-" data-method="PUT" data-path="api/chapters/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-chapters--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/chapters/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-chapters--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-chapters--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-chapters--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-chapters--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-chapters--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idModule</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idModule" data-endpoint="PUTapi-chapters--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/chapters/doloremque" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/chapters/doloremque"
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
    'http://localhost/api/chapters/doloremque',
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
<div id="execution-results-DELETEapi-chapters--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-chapters--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-chapters--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-chapters--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-chapters--id-"></code></pre>
</div>
<form id="form-DELETEapi-chapters--id-" data-method="DELETE" data-path="api/chapters/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-chapters--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/chapters/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-chapters--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-chapters--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-chapters--id-" data-component="url" required  hidden>
<br>

</p>
</form>



