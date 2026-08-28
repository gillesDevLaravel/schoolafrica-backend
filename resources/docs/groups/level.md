# Level


## Afficher la liste des niveaux (Level)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/levelsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/levelsall"
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
    'http://localhost/api/levelsall',
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
<div id="execution-results-POSTapi-levelsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-levelsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-levelsall"></code></pre>
</div>
<div id="execution-error-POSTapi-levelsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-levelsall"></code></pre>
</div>
<form id="form-POSTapi-levelsall" data-method="POST" data-path="api/levelsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-levelsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/levelsall</code></b>
</p>
<p>
<label id="auth-POSTapi-levelsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-levelsall" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;un niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/levels/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/levels/qui"
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
    'http://localhost/api/levels/qui',
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
<div id="execution-results-GETapi-levels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-levels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-levels--id-"></code></pre>
</div>
<div id="execution-error-GETapi-levels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-levels--id-"></code></pre>
</div>
<form id="form-GETapi-levels--id-" data-method="GET" data-path="api/levels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-levels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/levels/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-levels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-levels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-levels--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/levels" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"levels":[{"name":"ab","description":"a","idCycle":2,"idSchool":7,"idSection":15}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/levels"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "levels": [
        {
            "name": "ab",
            "description": "a",
            "idCycle": 2,
            "idSchool": 7,
            "idSection": 15
        }
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
    'http://localhost/api/levels',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'levels' => [
                [
                    'name' => 'ab',
                    'description' => 'a',
                    'idCycle' => 2,
                    'idSchool' => 7,
                    'idSection' => 15,
                ],
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
<div id="execution-results-POSTapi-levels" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-levels"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-levels"></code></pre>
</div>
<div id="execution-error-POSTapi-levels" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-levels"></code></pre>
</div>
<form id="form-POSTapi-levels" data-method="POST" data-path="api/levels" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-levels', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/levels</code></b>
</p>
<p>
<label id="auth-POSTapi-levels" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-levels" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>levels</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>levels[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="levels.0.name" data-endpoint="POSTapi-levels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="levels.0.description" data-endpoint="POSTapi-levels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels[].idCycle</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="levels.0.idCycle" data-endpoint="POSTapi-levels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="levels.0.idSchool" data-endpoint="POSTapi-levels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="levels.0.idSection" data-endpoint="POSTapi-levels" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## maj des infos d&#039;un niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/levels/quas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/levels/quas"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/levels/quas',
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
<div id="execution-results-PUTapi-levels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-levels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-levels--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-levels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-levels--id-"></code></pre>
</div>
<form id="form-PUTapi-levels--id-" data-method="PUT" data-path="api/levels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-levels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/levels/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-levels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-levels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-levels--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/levels/itaque" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/levels/itaque"
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
    'http://localhost/api/levels/itaque',
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
<div id="execution-results-DELETEapi-levels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-levels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-levels--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-levels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-levels--id-"></code></pre>
</div>
<form id="form-DELETEapi-levels--id-" data-method="DELETE" data-path="api/levels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-levels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/levels/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-levels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-levels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-levels--id-" data-component="url" required  hidden>
<br>

</p>
</form>



