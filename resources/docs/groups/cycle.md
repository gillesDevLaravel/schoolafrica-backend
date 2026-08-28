# Cycle


## Afficher la liste des cycles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cyclesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cyclesall"
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
    'http://localhost/api/cyclesall',
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
<div id="execution-results-POSTapi-cyclesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cyclesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cyclesall"></code></pre>
</div>
<div id="execution-error-POSTapi-cyclesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cyclesall"></code></pre>
</div>
<form id="form-POSTapi-cyclesall" data-method="POST" data-path="api/cyclesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cyclesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cyclesall</code></b>
</p>
<p>
<label id="auth-POSTapi-cyclesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cyclesall" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;un cycle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/cycles/nobis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cycles/nobis"
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
    'http://localhost/api/cycles/nobis',
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
<div id="execution-results-GETapi-cycles--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cycles--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cycles--id-"></code></pre>
</div>
<div id="execution-error-GETapi-cycles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cycles--id-"></code></pre>
</div>
<form id="form-GETapi-cycles--id-" data-method="GET" data-path="api/cycles/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cycles--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cycles/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-cycles--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-cycles--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-cycles--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un cycle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cycles" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cycles":[{"name":"earum","idSchool":17,"idCampus":18,"idSection":6,"description":"provident"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/cycles"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cycles": [
        {
            "name": "earum",
            "idSchool": 17,
            "idCampus": 18,
            "idSection": 6,
            "description": "provident"
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
    'http://localhost/api/cycles',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'cycles' => [
                [
                    'name' => 'earum',
                    'idSchool' => 17,
                    'idCampus' => 18,
                    'idSection' => 6,
                    'description' => 'provident',
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
<div id="execution-results-POSTapi-cycles" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cycles"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cycles"></code></pre>
</div>
<div id="execution-error-POSTapi-cycles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cycles"></code></pre>
</div>
<form id="form-POSTapi-cycles" data-method="POST" data-path="api/cycles" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cycles', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cycles</code></b>
</p>
<p>
<label id="auth-POSTapi-cycles" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cycles" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>cycles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>cycles[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="cycles.0.name" data-endpoint="POSTapi-cycles" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>cycles[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="cycles.0.idSchool" data-endpoint="POSTapi-cycles" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>cycles[].idCampus</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="cycles.0.idCampus" data-endpoint="POSTapi-cycles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>cycles[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="cycles.0.idSection" data-endpoint="POSTapi-cycles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>cycles[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="cycles.0.description" data-endpoint="POSTapi-cycles" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## maj des infos d&#039;un cycle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/cycles/in" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cycles/in"
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
    'http://localhost/api/cycles/in',
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
<div id="execution-results-PUTapi-cycles--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-cycles--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cycles--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-cycles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cycles--id-"></code></pre>
</div>
<form id="form-PUTapi-cycles--id-" data-method="PUT" data-path="api/cycles/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-cycles--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/cycles/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-cycles--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-cycles--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-cycles--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un cycle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/cycles/reprehenderit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cycles/reprehenderit"
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
    'http://localhost/api/cycles/reprehenderit',
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
<div id="execution-results-DELETEapi-cycles--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-cycles--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cycles--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-cycles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cycles--id-"></code></pre>
</div>
<form id="form-DELETEapi-cycles--id-" data-method="DELETE" data-path="api/cycles/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cycles--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/cycles/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-cycles--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-cycles--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-cycles--id-" data-component="url" required  hidden>
<br>

</p>
</form>



