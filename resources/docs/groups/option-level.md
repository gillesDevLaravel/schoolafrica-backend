# Option Level


## Afficher la liste des Options de Niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/optionlevelsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":18,"idSection":10,"idLevel":16,"idFiliere":9,"filter_value":"laboriosam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/optionlevelsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 18,
    "idSection": 10,
    "idLevel": 16,
    "idFiliere": 9,
    "filter_value": "laboriosam"
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
    'http://localhost/api/optionlevelsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 18,
            'idSection' => 10,
            'idLevel' => 16,
            'idFiliere' => 9,
            'filter_value' => 'laboriosam',
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
<div id="execution-results-POSTapi-optionlevelsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-optionlevelsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-optionlevelsall"></code></pre>
</div>
<div id="execution-error-POSTapi-optionlevelsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-optionlevelsall"></code></pre>
</div>
<form id="form-POSTapi-optionlevelsall" data-method="POST" data-path="api/optionlevelsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-optionlevelsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/optionlevelsall</code></b>
</p>
<p>
<label id="auth-POSTapi-optionlevelsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-optionlevelsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-optionlevelsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-optionlevelsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-optionlevelsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFiliere</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFiliere" data-endpoint="POSTapi-optionlevelsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-optionlevelsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les infos d&#039;un option de niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/optionlevels/quos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/optionlevels/quos"
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
    'http://localhost/api/optionlevels/quos',
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
<div id="execution-results-GETapi-optionlevels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-optionlevels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-optionlevels--id-"></code></pre>
</div>
<div id="execution-error-GETapi-optionlevels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-optionlevels--id-"></code></pre>
</div>
<form id="form-GETapi-optionlevels--id-" data-method="GET" data-path="api/optionlevels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-optionlevels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/optionlevels/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-optionlevels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-optionlevels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-optionlevels--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un option de niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/optionlevels" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"optionlevels":[{"name":"quos","idSchool":2,"idSection":15,"idFiliere":15,"description":"aliquid","lang":"sed"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/optionlevels"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "optionlevels": [
        {
            "name": "quos",
            "idSchool": 2,
            "idSection": 15,
            "idFiliere": 15,
            "description": "aliquid",
            "lang": "sed"
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
    'http://localhost/api/optionlevels',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'optionlevels' => [
                [
                    'name' => 'quos',
                    'idSchool' => 2,
                    'idSection' => 15,
                    'idFiliere' => 15,
                    'description' => 'aliquid',
                    'lang' => 'sed',
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
<div id="execution-results-POSTapi-optionlevels" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-optionlevels"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-optionlevels"></code></pre>
</div>
<div id="execution-error-POSTapi-optionlevels" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-optionlevels"></code></pre>
</div>
<form id="form-POSTapi-optionlevels" data-method="POST" data-path="api/optionlevels" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-optionlevels', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/optionlevels</code></b>
</p>
<p>
<label id="auth-POSTapi-optionlevels" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-optionlevels" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>optionlevels</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>optionlevels[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="optionlevels.0.name" data-endpoint="POSTapi-optionlevels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>optionlevels[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="optionlevels.0.idSchool" data-endpoint="POSTapi-optionlevels" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>optionlevels[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="optionlevels.0.idSection" data-endpoint="POSTapi-optionlevels" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>optionlevels[].idFiliere</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="optionlevels.0.idFiliere" data-endpoint="POSTapi-optionlevels" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>optionlevels[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="optionlevels.0.description" data-endpoint="POSTapi-optionlevels" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>optionlevels[].lang</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="optionlevels.0.lang" data-endpoint="POSTapi-optionlevels" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## maj des infos d&#039;un option de niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/optionlevels/facere" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/optionlevels/facere"
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
    'http://localhost/api/optionlevels/facere',
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
<div id="execution-results-PUTapi-optionlevels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-optionlevels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-optionlevels--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-optionlevels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-optionlevels--id-"></code></pre>
</div>
<form id="form-PUTapi-optionlevels--id-" data-method="PUT" data-path="api/optionlevels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-optionlevels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/optionlevels/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-optionlevels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-optionlevels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-optionlevels--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un option de niveau

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/optionlevels/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/optionlevels/qui"
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
    'http://localhost/api/optionlevels/qui',
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
<div id="execution-results-DELETEapi-optionlevels--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-optionlevels--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-optionlevels--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-optionlevels--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-optionlevels--id-"></code></pre>
</div>
<form id="form-DELETEapi-optionlevels--id-" data-method="DELETE" data-path="api/optionlevels/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-optionlevels--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/optionlevels/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-optionlevels--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-optionlevels--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-optionlevels--id-" data-component="url" required  hidden>
<br>

</p>
</form>



