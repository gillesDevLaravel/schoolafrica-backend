# Explanation Requests

Ce contrôleur gère toutes les opérations CRUD et d'archivage
concernant les demandes d'explication.

## Affiche la liste des demandes d&#039;explication avec possibilité de filtrage.

<small class="badge badge-darkred">requires authentication</small>

Filtres disponibles :
- name (recherche partielle)
- idSchool (exact)
- status (exact)
- date_start (date de création >=)
- date_end (date de création <=)

> Example request:

```bash
curl -X POST \
    "http://localhost/api/explanation-requestsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"hic","idSchool":19,"status":"pending","date_start":"dolorem","date_end":"sapiente"}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requestsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "hic",
    "idSchool": 19,
    "status": "pending",
    "date_start": "dolorem",
    "date_end": "sapiente"
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
    'http://localhost/api/explanation-requestsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'hic',
            'idSchool' => 19,
            'status' => 'pending',
            'date_start' => 'dolorem',
            'date_end' => 'sapiente',
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
<div id="execution-results-POSTapi-explanation-requestsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-explanation-requestsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-explanation-requestsall"></code></pre>
</div>
<div id="execution-error-POSTapi-explanation-requestsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-explanation-requestsall"></code></pre>
</div>
<form id="form-POSTapi-explanation-requestsall" data-method="POST" data-path="api/explanation-requestsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-explanation-requestsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/explanation-requestsall</code></b>
</p>
<p>
<label id="auth-POSTapi-explanation-requestsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-explanation-requestsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-explanation-requestsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-explanation-requestsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-explanation-requestsall" data-component="body"  hidden>
<br>
The value must be one of <code>pending</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-explanation-requestsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-explanation-requestsall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée une nouvelle demande d&#039;explication.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/explanation-requests" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"explanation_requests":[{"idSchool":1,"name":"suscipit","reason":"est","explanation":"ea","status":"approved"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "explanation_requests": [
        {
            "idSchool": 1,
            "name": "suscipit",
            "reason": "est",
            "explanation": "ea",
            "status": "approved"
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
    'http://localhost/api/explanation-requests',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'explanation_requests' => [
                [
                    'idSchool' => 1,
                    'name' => 'suscipit',
                    'reason' => 'est',
                    'explanation' => 'ea',
                    'status' => 'approved',
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
<div id="execution-results-POSTapi-explanation-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-explanation-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-explanation-requests"></code></pre>
</div>
<div id="execution-error-POSTapi-explanation-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-explanation-requests"></code></pre>
</div>
<form id="form-POSTapi-explanation-requests" data-method="POST" data-path="api/explanation-requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-explanation-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/explanation-requests</code></b>
</p>
<p>
<label id="auth-POSTapi-explanation-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-explanation-requests" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>explanation_requests</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>explanation_requests[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="explanation_requests.0.idSchool" data-endpoint="POSTapi-explanation-requests" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>explanation_requests[].name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="explanation_requests.0.name" data-endpoint="POSTapi-explanation-requests" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>explanation_requests[].reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="explanation_requests.0.reason" data-endpoint="POSTapi-explanation-requests" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>explanation_requests[].explanation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="explanation_requests.0.explanation" data-endpoint="POSTapi-explanation-requests" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>explanation_requests[].status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="explanation_requests.0.status" data-endpoint="POSTapi-explanation-requests" data-component="body"  hidden>
<br>
The value must be one of <code>pending</code>, <code>approved</code>, or <code>rejected</code>.
</p>
</details>
</p>

</form>


## Affiche une demande d&#039;explication spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/explanation-requests/voluptas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests/voluptas"
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
    'http://localhost/api/explanation-requests/voluptas',
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
<div id="execution-results-GETapi-explanation-requests--explanationRequest-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-explanation-requests--explanationRequest-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-explanation-requests--explanationRequest-"></code></pre>
</div>
<div id="execution-error-GETapi-explanation-requests--explanationRequest-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-explanation-requests--explanationRequest-"></code></pre>
</div>
<form id="form-GETapi-explanation-requests--explanationRequest-" data-method="GET" data-path="api/explanation-requests/{explanationRequest}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-explanation-requests--explanationRequest-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/explanation-requests/{explanationRequest}</code></b>
</p>
<p>
<label id="auth-GETapi-explanation-requests--explanationRequest-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-explanation-requests--explanationRequest-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>explanationRequest</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="explanationRequest" data-endpoint="GETapi-explanation-requests--explanationRequest-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour une demande d&#039;explication existante.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/explanation-requests/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":19,"name":"hic","reason":"vitae","explanation":"tempora","status":"rejected"}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 19,
    "name": "hic",
    "reason": "vitae",
    "explanation": "tempora",
    "status": "rejected"
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
    'http://localhost/api/explanation-requests/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 19,
            'name' => 'hic',
            'reason' => 'vitae',
            'explanation' => 'tempora',
            'status' => 'rejected',
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
<div id="execution-results-PUTapi-explanation-requests--explanationRequest-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-explanation-requests--explanationRequest-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-explanation-requests--explanationRequest-"></code></pre>
</div>
<div id="execution-error-PUTapi-explanation-requests--explanationRequest-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-explanation-requests--explanationRequest-"></code></pre>
</div>
<form id="form-PUTapi-explanation-requests--explanationRequest-" data-method="PUT" data-path="api/explanation-requests/{explanationRequest}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-explanation-requests--explanationRequest-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/explanation-requests/{explanationRequest}</code></b>
</p>
<p>
<label id="auth-PUTapi-explanation-requests--explanationRequest-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>explanationRequest</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="explanationRequest" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>explanation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="explanation" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-explanation-requests--explanationRequest-" data-component="body" required  hidden>
<br>
The value must be one of <code>pending</code>, <code>approved</code>, or <code>rejected</code>.
</p>

</form>


## Met des demandes d&#039;explication à la corbeille (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/explanation-requests/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[20,16]}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        20,
        16
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
    'http://localhost/api/explanation-requests/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                20,
                16,
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
<div id="execution-results-POSTapi-explanation-requests-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-explanation-requests-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-explanation-requests-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-explanation-requests-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-explanation-requests-trash"></code></pre>
</div>
<form id="form-POSTapi-explanation-requests-trash" data-method="POST" data-path="api/explanation-requests/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-explanation-requests-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/explanation-requests/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-explanation-requests-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-explanation-requests-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-explanation-requests-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-explanation-requests-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure des demandes d&#039;explication supprimées (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/explanation-requests/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[14,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        14,
        11
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
    'http://localhost/api/explanation-requests/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                14,
                11,
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
<div id="execution-results-POSTapi-explanation-requests-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-explanation-requests-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-explanation-requests-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-explanation-requests-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-explanation-requests-restore"></code></pre>
</div>
<form id="form-POSTapi-explanation-requests-restore" data-method="POST" data-path="api/explanation-requests/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-explanation-requests-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/explanation-requests/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-explanation-requests-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-explanation-requests-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-explanation-requests-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-explanation-requests-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement des demandes d&#039;explication (hard delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/explanation-requests/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[18,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/explanation-requests/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        18,
        20
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
    'http://localhost/api/explanation-requests/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                18,
                20,
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
<div id="execution-results-POSTapi-explanation-requests-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-explanation-requests-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-explanation-requests-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-explanation-requests-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-explanation-requests-delete"></code></pre>
</div>
<form id="form-POSTapi-explanation-requests-delete" data-method="POST" data-path="api/explanation-requests/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-explanation-requests-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/explanation-requests/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-explanation-requests-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-explanation-requests-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-explanation-requests-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-explanation-requests-delete" data-component="body" hidden>
<br>

</p>

</form>



