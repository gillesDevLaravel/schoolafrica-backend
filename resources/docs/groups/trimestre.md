# Trimestre


## Ajouter un trimestre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/trimestres" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"trimestres":[{"name":"non","numbering":1,"idSchool":2,"idSection":1,"idSemestre":3,"takenIntoAccount":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/trimestres"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "trimestres": [
        {
            "name": "non",
            "numbering": 1,
            "idSchool": 2,
            "idSection": 1,
            "idSemestre": 3,
            "takenIntoAccount": false
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
    'http://localhost/api/trimestres',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'trimestres' => [
                [
                    'name' => 'non',
                    'numbering' => 1,
                    'idSchool' => 2,
                    'idSection' => 1,
                    'idSemestre' => 3,
                    'takenIntoAccount' => false,
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
<div id="execution-results-POSTapi-trimestres" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-trimestres"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-trimestres"></code></pre>
</div>
<div id="execution-error-POSTapi-trimestres" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-trimestres"></code></pre>
</div>
<form id="form-POSTapi-trimestres" data-method="POST" data-path="api/trimestres" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-trimestres', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/trimestres</code></b>
</p>
<p>
<label id="auth-POSTapi-trimestres" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-trimestres" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>trimestres</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>trimestres[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="trimestres.0.name" data-endpoint="POSTapi-trimestres" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>trimestres[].numbering</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="trimestres.0.numbering" data-endpoint="POSTapi-trimestres" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trimestres[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="trimestres.0.idSchool" data-endpoint="POSTapi-trimestres" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>trimestres[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="trimestres.0.idSection" data-endpoint="POSTapi-trimestres" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>trimestres[].idSemestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="trimestres.0.idSemestre" data-endpoint="POSTapi-trimestres" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trimestres[].takenIntoAccount</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-trimestres" hidden><input type="radio" name="trimestres.0.takenIntoAccount" value="true" data-endpoint="POSTapi-trimestres" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-trimestres" hidden><input type="radio" name="trimestres.0.takenIntoAccount" value="false" data-endpoint="POSTapi-trimestres" data-component="body" ><code>false</code></label>
<br>

</p>
</details>
</p>

</form>


## Aficher les informations d&#039;un trimestre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/trimestres/adipisci" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/trimestres/adipisci"
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
    'http://localhost/api/trimestres/adipisci',
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
<div id="execution-results-GETapi-trimestres--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-trimestres--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-trimestres--id-"></code></pre>
</div>
<div id="execution-error-GETapi-trimestres--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-trimestres--id-"></code></pre>
</div>
<form id="form-GETapi-trimestres--id-" data-method="GET" data-path="api/trimestres/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-trimestres--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/trimestres/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-trimestres--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-trimestres--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-trimestres--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Afficher la liste des trimestres

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/trimestresall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/trimestresall"
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
    'http://localhost/api/trimestresall',
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
<div id="execution-results-POSTapi-trimestresall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-trimestresall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-trimestresall"></code></pre>
</div>
<div id="execution-error-POSTapi-trimestresall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-trimestresall"></code></pre>
</div>
<form id="form-POSTapi-trimestresall" data-method="POST" data-path="api/trimestresall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-trimestresall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/trimestresall</code></b>
</p>
<p>
<label id="auth-POSTapi-trimestresall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-trimestresall" data-component="header"></label>
</p>
</form>


## Mettre à jour les informations d&#039;un trimestre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/trimestres/ipsam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/trimestres/ipsam"
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
    'http://localhost/api/trimestres/ipsam',
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
<div id="execution-results-PUTapi-trimestres--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-trimestres--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-trimestres--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-trimestres--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-trimestres--id-"></code></pre>
</div>
<form id="form-PUTapi-trimestres--id-" data-method="PUT" data-path="api/trimestres/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-trimestres--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/trimestres/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-trimestres--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-trimestres--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-trimestres--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un trimestre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/trimestres/sequi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/trimestres/sequi"
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
    'http://localhost/api/trimestres/sequi',
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
<div id="execution-results-DELETEapi-trimestres--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-trimestres--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-trimestres--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-trimestres--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-trimestres--id-"></code></pre>
</div>
<form id="form-DELETEapi-trimestres--id-" data-method="DELETE" data-path="api/trimestres/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-trimestres--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/trimestres/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-trimestres--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-trimestres--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-trimestres--id-" data-component="url" required  hidden>
<br>

</p>
</form>



