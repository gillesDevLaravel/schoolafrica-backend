# Coefficient


## Afficher la liste des coefficients

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/coefficientsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":6,"idSection":15,"idLevel":5,"idMatter":5,"idOptionLevel":6}'

```

```javascript
const url = new URL(
    "http://localhost/api/coefficientsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 6,
    "idSection": 15,
    "idLevel": 5,
    "idMatter": 5,
    "idOptionLevel": 6
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
    'http://localhost/api/coefficientsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 6,
            'idSection' => 15,
            'idLevel' => 5,
            'idMatter' => 5,
            'idOptionLevel' => 6,
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
<div id="execution-results-POSTapi-coefficientsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-coefficientsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-coefficientsall"></code></pre>
</div>
<div id="execution-error-POSTapi-coefficientsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-coefficientsall"></code></pre>
</div>
<form id="form-POSTapi-coefficientsall" data-method="POST" data-path="api/coefficientsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-coefficientsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/coefficientsall</code></b>
</p>
<p>
<label id="auth-POSTapi-coefficientsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-coefficientsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-coefficientsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-coefficientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-coefficientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-coefficientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-coefficientsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les infos d&#039;un coefficient

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/coefficients/a" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/coefficients/a"
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
    'http://localhost/api/coefficients/a',
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
<div id="execution-results-GETapi-coefficients--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-coefficients--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-coefficients--id-"></code></pre>
</div>
<div id="execution-error-GETapi-coefficients--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-coefficients--id-"></code></pre>
</div>
<form id="form-GETapi-coefficients--id-" data-method="GET" data-path="api/coefficients/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-coefficients--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/coefficients/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-coefficients--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-coefficients--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-coefficients--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un coefficient

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/coefficients" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"value":"placeat","idMatter":14,"idSchool":8,"idSection":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/coefficients"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "value": "placeat",
    "idMatter": 14,
    "idSchool": 8,
    "idSection": 4
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
    'http://localhost/api/coefficients',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'value' => 'placeat',
            'idMatter' => 14,
            'idSchool' => 8,
            'idSection' => 4,
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
<div id="execution-results-POSTapi-coefficients" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-coefficients"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-coefficients"></code></pre>
</div>
<div id="execution-error-POSTapi-coefficients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-coefficients"></code></pre>
</div>
<form id="form-POSTapi-coefficients" data-method="POST" data-path="api/coefficients" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-coefficients', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/coefficients</code></b>
</p>
<p>
<label id="auth-POSTapi-coefficients" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-coefficients" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>value</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="value" data-endpoint="POSTapi-coefficients" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-coefficients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-coefficients" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-coefficients" data-component="body"  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un coefficient

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/coefficients/in" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"value":"nihil","idMatter":15,"idSchool":3,"idSection":10}'

```

```javascript
const url = new URL(
    "http://localhost/api/coefficients/in"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "value": "nihil",
    "idMatter": 15,
    "idSchool": 3,
    "idSection": 10
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
    'http://localhost/api/coefficients/in',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'value' => 'nihil',
            'idMatter' => 15,
            'idSchool' => 3,
            'idSection' => 10,
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
<div id="execution-results-PUTapi-coefficients--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-coefficients--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-coefficients--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-coefficients--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-coefficients--id-"></code></pre>
</div>
<form id="form-PUTapi-coefficients--id-" data-method="PUT" data-path="api/coefficients/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-coefficients--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/coefficients/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-coefficients--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-coefficients--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-coefficients--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>value</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="value" data-endpoint="PUTapi-coefficients--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="PUTapi-coefficients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-coefficients--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-coefficients--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer un coefficient

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/coefficients/esse" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/coefficients/esse"
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
    'http://localhost/api/coefficients/esse',
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
<div id="execution-results-DELETEapi-coefficients--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-coefficients--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-coefficients--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-coefficients--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-coefficients--id-"></code></pre>
</div>
<form id="form-DELETEapi-coefficients--id-" data-method="DELETE" data-path="api/coefficients/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-coefficients--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/coefficients/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-coefficients--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-coefficients--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-coefficients--id-" data-component="url" required  hidden>
<br>

</p>
</form>



