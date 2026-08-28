# Campus


## Afficher la liste des Campus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/campusall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/campusall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/campusall',
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
<div id="execution-results-POSTapi-campusall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-campusall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-campusall"></code></pre>
</div>
<div id="execution-error-POSTapi-campusall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-campusall"></code></pre>
</div>
<form id="form-POSTapi-campusall" data-method="POST" data-path="api/campusall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-campusall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/campusall</code></b>
</p>
<p>
<label id="auth-POSTapi-campusall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-campusall" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;un Campus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/campus/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/campus/sint"
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
    'http://localhost/api/campus/sint',
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
<div id="execution-results-GETapi-campus--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-campus--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-campus--id-"></code></pre>
</div>
<div id="execution-error-GETapi-campus--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-campus--id-"></code></pre>
</div>
<form id="form-GETapi-campus--id-" data-method="GET" data-path="api/campus/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-campus--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/campus/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-campus--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-campus--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-campus--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un Campus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/campus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"quis","adresse":"sequi","name":"eos"}'

```

```javascript
const url = new URL(
    "http://localhost/api/campus"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "quis",
    "adresse": "sequi",
    "name": "eos"
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
    'http://localhost/api/campus',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'quis',
            'adresse' => 'sequi',
            'name' => 'eos',
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
<div id="execution-results-POSTapi-campus" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-campus"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-campus"></code></pre>
</div>
<div id="execution-error-POSTapi-campus" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-campus"></code></pre>
</div>
<form id="form-POSTapi-campus" data-method="POST" data-path="api/campus" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-campus', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/campus</code></b>
</p>
<p>
<label id="auth-POSTapi-campus" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-campus" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-campus" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="adresse" data-endpoint="POSTapi-campus" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-campus" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un Campus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/campus/minima" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"iure","adresse":"non","name":"dolorum"}'

```

```javascript
const url = new URL(
    "http://localhost/api/campus/minima"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "iure",
    "adresse": "non",
    "name": "dolorum"
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
    'http://localhost/api/campus/minima',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'iure',
            'adresse' => 'non',
            'name' => 'dolorum',
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
<div id="execution-results-PUTapi-campus--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-campus--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-campus--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-campus--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-campus--id-"></code></pre>
</div>
<form id="form-PUTapi-campus--id-" data-method="PUT" data-path="api/campus/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-campus--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/campus/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-campus--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-campus--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-campus--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="PUTapi-campus--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="adresse" data-endpoint="PUTapi-campus--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-campus--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Supprimer un Campus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/campus/vitae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/campus/vitae"
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
    'http://localhost/api/campus/vitae',
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
<div id="execution-results-DELETEapi-campus--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-campus--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-campus--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-campus--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-campus--id-"></code></pre>
</div>
<form id="form-DELETEapi-campus--id-" data-method="DELETE" data-path="api/campus/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-campus--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/campus/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-campus--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-campus--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-campus--id-" data-component="url" required  hidden>
<br>

</p>
</form>



