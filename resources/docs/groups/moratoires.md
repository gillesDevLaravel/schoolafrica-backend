# Moratoires
Gestion des Moratoires

## Afficher la liste des moratoires filtrée

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moratoriumsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":3,"nbreItems":10,"filter_value":"fuga","idUser":13,"idUserApprove":12,"status":"rejected","start_date_from":"2025-11-22T14:46:51+0000","start_date_to":"2025-11-22T14:46:51+0000","end_date_from":"2025-11-22T14:46:51+0000","end_date_to":"2025-11-22T14:46:51+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriumsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 3,
    "nbreItems": 10,
    "filter_value": "fuga",
    "idUser": 13,
    "idUserApprove": 12,
    "status": "rejected",
    "start_date_from": "2025-11-22T14:46:51+0000",
    "start_date_to": "2025-11-22T14:46:51+0000",
    "end_date_from": "2025-11-22T14:46:51+0000",
    "end_date_to": "2025-11-22T14:46:51+0000"
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
    'http://localhost/api/moratoriumsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 3,
            'nbreItems' => 10,
            'filter_value' => 'fuga',
            'idUser' => 13,
            'idUserApprove' => 12,
            'status' => 'rejected',
            'start_date_from' => '2025-11-22T14:46:51+0000',
            'start_date_to' => '2025-11-22T14:46:51+0000',
            'end_date_from' => '2025-11-22T14:46:51+0000',
            'end_date_to' => '2025-11-22T14:46:51+0000',
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
<div id="execution-results-POSTapi-moratoriumsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moratoriumsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moratoriumsall"></code></pre>
</div>
<div id="execution-error-POSTapi-moratoriumsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moratoriumsall"></code></pre>
</div>
<form id="form-POSTapi-moratoriumsall" data-method="POST" data-path="api/moratoriumsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moratoriumsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moratoriumsall</code></b>
</p>
<p>
<label id="auth-POSTapi-moratoriumsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moratoriumsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>start_date_from</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date_from" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>start_date_to</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date_to" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date_from</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date_from" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date_to</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date_to" data-endpoint="POSTapi-moratoriumsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Ajouter un nouveau moratoire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moratoriums" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":11,"startDate":"2025-11-22T14:46:51+0000","endDate":"2025-11-22T14:46:51+0000","reason":"velit","status":"pending_approval","idUserApprove":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 11,
    "startDate": "2025-11-22T14:46:51+0000",
    "endDate": "2025-11-22T14:46:51+0000",
    "reason": "velit",
    "status": "pending_approval",
    "idUserApprove": 3
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
    'http://localhost/api/moratoriums',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 11,
            'startDate' => '2025-11-22T14:46:51+0000',
            'endDate' => '2025-11-22T14:46:51+0000',
            'reason' => 'velit',
            'status' => 'pending_approval',
            'idUserApprove' => 3,
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
<div id="execution-results-POSTapi-moratoriums" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moratoriums"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moratoriums"></code></pre>
</div>
<div id="execution-error-POSTapi-moratoriums" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moratoriums"></code></pre>
</div>
<form id="form-POSTapi-moratoriums" data-method="POST" data-path="api/moratoriums" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moratoriums', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moratoriums</code></b>
</p>
<p>
<label id="auth-POSTapi-moratoriums" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moratoriums" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-moratoriums" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="startDate" data-endpoint="POSTapi-moratoriums" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="endDate" data-endpoint="POSTapi-moratoriums" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-moratoriums" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-moratoriums" data-component="body" required  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>expired</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-moratoriums" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher un moratoire spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/moratoriums/quo" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums/quo"
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
    'http://localhost/api/moratoriums/quo',
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
<div id="execution-results-GETapi-moratoriums--moratorium-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-moratoriums--moratorium-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-moratoriums--moratorium-"></code></pre>
</div>
<div id="execution-error-GETapi-moratoriums--moratorium-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-moratoriums--moratorium-"></code></pre>
</div>
<form id="form-GETapi-moratoriums--moratorium-" data-method="GET" data-path="api/moratoriums/{moratorium}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-moratoriums--moratorium-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/moratoriums/{moratorium}</code></b>
</p>
<p>
<label id="auth-GETapi-moratoriums--moratorium-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-moratoriums--moratorium-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>moratorium</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="moratorium" data-endpoint="GETapi-moratoriums--moratorium-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier un moratoire spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/moratoriums/consequuntur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":1,"startDate":"2025-11-22T14:46:51+0000","endDate":"2025-11-22T14:46:51+0000","reason":"sint","status":"pending_approval","idUserApprove":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums/consequuntur"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 1,
    "startDate": "2025-11-22T14:46:51+0000",
    "endDate": "2025-11-22T14:46:51+0000",
    "reason": "sint",
    "status": "pending_approval",
    "idUserApprove": 2
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
    'http://localhost/api/moratoriums/consequuntur',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 1,
            'startDate' => '2025-11-22T14:46:51+0000',
            'endDate' => '2025-11-22T14:46:51+0000',
            'reason' => 'sint',
            'status' => 'pending_approval',
            'idUserApprove' => 2,
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
<div id="execution-results-PUTapi-moratoriums--moratorium-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-moratoriums--moratorium-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-moratoriums--moratorium-"></code></pre>
</div>
<div id="execution-error-PUTapi-moratoriums--moratorium-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-moratoriums--moratorium-"></code></pre>
</div>
<form id="form-PUTapi-moratoriums--moratorium-" data-method="PUT" data-path="api/moratoriums/{moratorium}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-moratoriums--moratorium-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/moratoriums/{moratorium}</code></b>
</p>
<p>
<label id="auth-PUTapi-moratoriums--moratorium-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-moratoriums--moratorium-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>moratorium</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="moratorium" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="startDate" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="endDate" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>expired</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="PUTapi-moratoriums--moratorium-" data-component="body"  hidden>
<br>

</p>

</form>


## Mettre un moratoire à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moratoriums/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[12,9]}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        12,
        9
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
    'http://localhost/api/moratoriums/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                12,
                9,
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
<div id="execution-results-POSTapi-moratoriums-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moratoriums-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moratoriums-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-moratoriums-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moratoriums-trash"></code></pre>
</div>
<form id="form-POSTapi-moratoriums-trash" data-method="POST" data-path="api/moratoriums/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moratoriums-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moratoriums/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-moratoriums-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moratoriums-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-moratoriums-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-moratoriums-trash" data-component="body" hidden>
<br>

</p>

</form>


## Retirer un ou plusieurs moratoires de la corbeille (restauration).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moratoriums/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[13,2]}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        13,
        2
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
    'http://localhost/api/moratoriums/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                13,
                2,
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
<div id="execution-results-POSTapi-moratoriums-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moratoriums-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moratoriums-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-moratoriums-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moratoriums-restore"></code></pre>
</div>
<form id="form-POSTapi-moratoriums-restore" data-method="POST" data-path="api/moratoriums/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moratoriums-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moratoriums/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-moratoriums-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moratoriums-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-moratoriums-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-moratoriums-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer définitivement un ou plusieurs moratoires.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moratoriums/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[13,1]}'

```

```javascript
const url = new URL(
    "http://localhost/api/moratoriums/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        13,
        1
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
    'http://localhost/api/moratoriums/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                13,
                1,
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
<div id="execution-results-POSTapi-moratoriums-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moratoriums-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moratoriums-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-moratoriums-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moratoriums-delete"></code></pre>
</div>
<form id="form-POSTapi-moratoriums-delete" data-method="POST" data-path="api/moratoriums/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moratoriums-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moratoriums/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-moratoriums-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moratoriums-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-moratoriums-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-moratoriums-delete" data-component="body" hidden>
<br>

</p>

</form>



