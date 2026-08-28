# Assessment Type


## Listing des AssessmentType

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessmenttypesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"takenIntoAccount":false,"idSchool":5,"idSection":5}'

```

```javascript
const url = new URL(
    "http://localhost/api/assessmenttypesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "takenIntoAccount": false,
    "idSchool": 5,
    "idSection": 5
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
    'http://localhost/api/assessmenttypesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'takenIntoAccount' => false,
            'idSchool' => 5,
            'idSection' => 5,
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
<div id="execution-results-POSTapi-assessmenttypesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessmenttypesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessmenttypesall"></code></pre>
</div>
<div id="execution-error-POSTapi-assessmenttypesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessmenttypesall"></code></pre>
</div>
<form id="form-POSTapi-assessmenttypesall" data-method="POST" data-path="api/assessmenttypesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessmenttypesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessmenttypesall</code></b>
</p>
<p>
<label id="auth-POSTapi-assessmenttypesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessmenttypesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>takenIntoAccount</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-assessmenttypesall" hidden><input type="radio" name="takenIntoAccount" value="true" data-endpoint="POSTapi-assessmenttypesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-assessmenttypesall" hidden><input type="radio" name="takenIntoAccount" value="false" data-endpoint="POSTapi-assessmenttypesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-assessmenttypesall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-assessmenttypesall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une séquence (AssessmentType)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/assessmenttypes/voluptas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessmenttypes/voluptas"
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
    'http://localhost/api/assessmenttypes/voluptas',
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
<div id="execution-results-GETapi-assessmenttypes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-assessmenttypes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-assessmenttypes--id-"></code></pre>
</div>
<div id="execution-error-GETapi-assessmenttypes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-assessmenttypes--id-"></code></pre>
</div>
<form id="form-GETapi-assessmenttypes--id-" data-method="GET" data-path="api/assessmenttypes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-assessmenttypes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/assessmenttypes/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-assessmenttypes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-assessmenttypes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-assessmenttypes--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessmenttypes" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"assessmenttypes":[{"name":"consequatur","idTrimestre":4,"takenIntoAccount":false,"numbering":4,"pourcentage":3479198}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/assessmenttypes"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "assessmenttypes": [
        {
            "name": "consequatur",
            "idTrimestre": 4,
            "takenIntoAccount": false,
            "numbering": 4,
            "pourcentage": 3479198
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
    'http://localhost/api/assessmenttypes',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'assessmenttypes' => [
                [
                    'name' => 'consequatur',
                    'idTrimestre' => 4,
                    'takenIntoAccount' => false,
                    'numbering' => 4,
                    'pourcentage' => 3479198.0,
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
<div id="execution-results-POSTapi-assessmenttypes" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessmenttypes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessmenttypes"></code></pre>
</div>
<div id="execution-error-POSTapi-assessmenttypes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessmenttypes"></code></pre>
</div>
<form id="form-POSTapi-assessmenttypes" data-method="POST" data-path="api/assessmenttypes" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessmenttypes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessmenttypes</code></b>
</p>
<p>
<label id="auth-POSTapi-assessmenttypes" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessmenttypes" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>assessmenttypes</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>assessmenttypes[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="assessmenttypes.0.name" data-endpoint="POSTapi-assessmenttypes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>assessmenttypes[].idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="assessmenttypes.0.idTrimestre" data-endpoint="POSTapi-assessmenttypes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>assessmenttypes[].takenIntoAccount</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-assessmenttypes" hidden><input type="radio" name="assessmenttypes.0.takenIntoAccount" value="true" data-endpoint="POSTapi-assessmenttypes" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-assessmenttypes" hidden><input type="radio" name="assessmenttypes.0.takenIntoAccount" value="false" data-endpoint="POSTapi-assessmenttypes" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>assessmenttypes[].numbering</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="assessmenttypes.0.numbering" data-endpoint="POSTapi-assessmenttypes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessmenttypes[].pourcentage</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="assessmenttypes.0.pourcentage" data-endpoint="POSTapi-assessmenttypes" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Mise à jour des infos d&#039;une séquence

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/assessmenttypes/consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessmenttypes/consequatur"
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
    'http://localhost/api/assessmenttypes/consequatur',
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
<div id="execution-results-PUTapi-assessmenttypes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-assessmenttypes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-assessmenttypes--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-assessmenttypes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-assessmenttypes--id-"></code></pre>
</div>
<form id="form-PUTapi-assessmenttypes--id-" data-method="PUT" data-path="api/assessmenttypes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-assessmenttypes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/assessmenttypes/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-assessmenttypes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-assessmenttypes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-assessmenttypes--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer une séquence (#trash)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/assessmenttypes/est" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessmenttypes/est"
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
    'http://localhost/api/assessmenttypes/est',
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
<div id="execution-results-DELETEapi-assessmenttypes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-assessmenttypes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-assessmenttypes--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-assessmenttypes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-assessmenttypes--id-"></code></pre>
</div>
<form id="form-DELETEapi-assessmenttypes--id-" data-method="DELETE" data-path="api/assessmenttypes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-assessmenttypes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/assessmenttypes/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-assessmenttypes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-assessmenttypes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-assessmenttypes--id-" data-component="url" required  hidden>
<br>

</p>
</form>



