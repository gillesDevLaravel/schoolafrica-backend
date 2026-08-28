# Rapports journalier / Daily reports

Gestion des rapports journaliers

## Afficher la liste des rapports journaliers filtrés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/daily-reportsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"explicabo","nbreItems":15,"pageItems":2,"idUser":6,"date":"2025-11-22T14:46:53+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reportsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "explicabo",
    "nbreItems": 15,
    "pageItems": 2,
    "idUser": 6,
    "date": "2025-11-22T14:46:53+0000"
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
    'http://localhost/api/daily-reportsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'explicabo',
            'nbreItems' => 15,
            'pageItems' => 2,
            'idUser' => 6,
            'date' => '2025-11-22T14:46:53+0000',
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
<div id="execution-results-POSTapi-daily-reportsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-daily-reportsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-daily-reportsall"></code></pre>
</div>
<div id="execution-error-POSTapi-daily-reportsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-daily-reportsall"></code></pre>
</div>
<form id="form-POSTapi-daily-reportsall" data-method="POST" data-path="api/daily-reportsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-daily-reportsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/daily-reportsall</code></b>
</p>
<p>
<label id="auth-POSTapi-daily-reportsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-daily-reportsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-daily-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-daily-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-daily-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-daily-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-daily-reportsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Ajouter un nouveau rapport journalier.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/daily-reports" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"est","date":"2025-11-22T14:46:53+0000","description":"laborum","user_id":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "est",
    "date": "2025-11-22T14:46:53+0000",
    "description": "laborum",
    "user_id": 3
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
    'http://localhost/api/daily-reports',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'est',
            'date' => '2025-11-22T14:46:53+0000',
            'description' => 'laborum',
            'user_id' => 3,
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
<div id="execution-results-POSTapi-daily-reports" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-daily-reports"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-daily-reports"></code></pre>
</div>
<div id="execution-error-POSTapi-daily-reports" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-daily-reports"></code></pre>
</div>
<form id="form-POSTapi-daily-reports" data-method="POST" data-path="api/daily-reports" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-daily-reports', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/daily-reports</code></b>
</p>
<p>
<label id="auth-POSTapi-daily-reports" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-daily-reports" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-daily-reports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-daily-reports" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-daily-reports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-daily-reports" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher un rapport journalier spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/daily-reports/nulla" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports/nulla"
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
    'http://localhost/api/daily-reports/nulla',
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
<div id="execution-results-GETapi-daily-reports--dailyReport-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-daily-reports--dailyReport-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-daily-reports--dailyReport-"></code></pre>
</div>
<div id="execution-error-GETapi-daily-reports--dailyReport-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-daily-reports--dailyReport-"></code></pre>
</div>
<form id="form-GETapi-daily-reports--dailyReport-" data-method="GET" data-path="api/daily-reports/{dailyReport}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-daily-reports--dailyReport-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/daily-reports/{dailyReport}</code></b>
</p>
<p>
<label id="auth-GETapi-daily-reports--dailyReport-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-daily-reports--dailyReport-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>dailyReport</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="dailyReport" data-endpoint="GETapi-daily-reports--dailyReport-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/daily-reports/quo" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"quaerat","date":"2025-11-22T14:46:53+0000","description":"voluptatem","user_id":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports/quo"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "quaerat",
    "date": "2025-11-22T14:46:53+0000",
    "description": "voluptatem",
    "user_id": 20
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
    'http://localhost/api/daily-reports/quo',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'quaerat',
            'date' => '2025-11-22T14:46:53+0000',
            'description' => 'voluptatem',
            'user_id' => 20,
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
<div id="execution-results-PUTapi-daily-reports--dailyReport-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-daily-reports--dailyReport-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-daily-reports--dailyReport-"></code></pre>
</div>
<div id="execution-error-PUTapi-daily-reports--dailyReport-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-daily-reports--dailyReport-"></code></pre>
</div>
<form id="form-PUTapi-daily-reports--dailyReport-" data-method="PUT" data-path="api/daily-reports/{dailyReport}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-daily-reports--dailyReport-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/daily-reports/{dailyReport}</code></b>
</p>
<p>
<label id="auth-PUTapi-daily-reports--dailyReport-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>dailyReport</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="dailyReport" data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="PUTapi-daily-reports--dailyReport-" data-component="body"  hidden>
<br>

</p>

</form>


## Archivage multiple des rapports journalier

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/daily-reports/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[10,4]}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        10,
        4
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
    'http://localhost/api/daily-reports/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                10,
                4,
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
<div id="execution-results-POSTapi-daily-reports-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-daily-reports-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-daily-reports-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-daily-reports-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-daily-reports-trash"></code></pre>
</div>
<form id="form-POSTapi-daily-reports-trash" data-method="POST" data-path="api/daily-reports/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-daily-reports-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/daily-reports/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-daily-reports-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-daily-reports-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-daily-reports-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-daily-reports-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restauration multiple des rapports journaliers

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/daily-reports/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[11,19]}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        11,
        19
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
    'http://localhost/api/daily-reports/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                11,
                19,
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
<div id="execution-results-POSTapi-daily-reports-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-daily-reports-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-daily-reports-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-daily-reports-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-daily-reports-restore"></code></pre>
</div>
<form id="form-POSTapi-daily-reports-restore" data-method="POST" data-path="api/daily-reports/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-daily-reports-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/daily-reports/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-daily-reports-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-daily-reports-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-daily-reports-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-daily-reports-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/daily-reports/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[4,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/daily-reports/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        4,
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
    'http://localhost/api/daily-reports/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                4,
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
<div id="execution-results-POSTapi-daily-reports-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-daily-reports-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-daily-reports-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-daily-reports-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-daily-reports-delete"></code></pre>
</div>
<form id="form-POSTapi-daily-reports-delete" data-method="POST" data-path="api/daily-reports/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-daily-reports-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/daily-reports/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-daily-reports-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-daily-reports-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-daily-reports-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-daily-reports-delete" data-component="body" hidden>
<br>

</p>

</form>



