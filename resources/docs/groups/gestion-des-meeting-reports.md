# Gestion des Meeting Reports

Ce contrôleur gère toutes les opérations CRUD et d'archivage
concernant les comptes-rendus de réunion.

## Affiche la liste des comptes-rendus avec possibilité de filtrage.

<small class="badge badge-darkred">requires authentication</small>

Filtres disponibles :
- name (recherche partielle)
- type (exact)

> Example request:

```bash
curl -X POST \
    "http://localhost/api/meeting-reportsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"consequatur","type":"quam","status":"incidunt","filter_value":"molestiae","date_start":"2026-03-11T10:55:29+0000","date_end":"2026-03-11T10:55:29+0000","pageItems":3,"nbreItems":5}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reportsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "consequatur",
    "type": "quam",
    "status": "incidunt",
    "filter_value": "molestiae",
    "date_start": "2026-03-11T10:55:29+0000",
    "date_end": "2026-03-11T10:55:29+0000",
    "pageItems": 3,
    "nbreItems": 5
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
    'http://localhost/api/meeting-reportsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'consequatur',
            'type' => 'quam',
            'status' => 'incidunt',
            'filter_value' => 'molestiae',
            'date_start' => '2026-03-11T10:55:29+0000',
            'date_end' => '2026-03-11T10:55:29+0000',
            'pageItems' => 3,
            'nbreItems' => 5,
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
<div id="execution-results-POSTapi-meeting-reportsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-meeting-reportsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meeting-reportsall"></code></pre>
</div>
<div id="execution-error-POSTapi-meeting-reportsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meeting-reportsall"></code></pre>
</div>
<form id="form-POSTapi-meeting-reportsall" data-method="POST" data-path="api/meeting-reportsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-meeting-reportsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/meeting-reportsall</code></b>
</p>
<p>
<label id="auth-POSTapi-meeting-reportsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-meeting-reportsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-meeting-reportsall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouveau compte-rendu.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/meeting-reports" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"meeting_reports":[{"name":"exercitationem","type":"porro","description":"quos"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "meeting_reports": [
        {
            "name": "exercitationem",
            "type": "porro",
            "description": "quos"
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
    'http://localhost/api/meeting-reports',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'meeting_reports' => [
                [
                    'name' => 'exercitationem',
                    'type' => 'porro',
                    'description' => 'quos',
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
<div id="execution-results-POSTapi-meeting-reports" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-meeting-reports"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meeting-reports"></code></pre>
</div>
<div id="execution-error-POSTapi-meeting-reports" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meeting-reports"></code></pre>
</div>
<form id="form-POSTapi-meeting-reports" data-method="POST" data-path="api/meeting-reports" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-meeting-reports', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/meeting-reports</code></b>
</p>
<p>
<label id="auth-POSTapi-meeting-reports" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-meeting-reports" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>meeting_reports</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>meeting_reports[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="meeting_reports.0.name" data-endpoint="POSTapi-meeting-reports" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>meeting_reports[].type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="meeting_reports.0.type" data-endpoint="POSTapi-meeting-reports" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>meeting_reports[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="meeting_reports.0.description" data-endpoint="POSTapi-meeting-reports" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Affiche un compte-rendu spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/meeting-reports/optio" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports/optio"
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
    'http://localhost/api/meeting-reports/optio',
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
<div id="execution-results-GETapi-meeting-reports--meeting_report-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-meeting-reports--meeting_report-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-meeting-reports--meeting_report-"></code></pre>
</div>
<div id="execution-error-GETapi-meeting-reports--meeting_report-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-meeting-reports--meeting_report-"></code></pre>
</div>
<form id="form-GETapi-meeting-reports--meeting_report-" data-method="GET" data-path="api/meeting-reports/{meeting_report}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-meeting-reports--meeting_report-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/meeting-reports/{meeting_report}</code></b>
</p>
<p>
<label id="auth-GETapi-meeting-reports--meeting_report-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-meeting-reports--meeting_report-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>meeting_report</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="meeting_report" data-endpoint="GETapi-meeting-reports--meeting_report-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un compte-rendu existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/meeting-reports/dolor" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"vel","type":"cupiditate","description":"dolorem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports/dolor"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vel",
    "type": "cupiditate",
    "description": "dolorem"
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
    'http://localhost/api/meeting-reports/dolor',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'vel',
            'type' => 'cupiditate',
            'description' => 'dolorem',
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
<div id="execution-results-PUTapi-meeting-reports--meeting_report-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-meeting-reports--meeting_report-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-meeting-reports--meeting_report-"></code></pre>
</div>
<div id="execution-error-PUTapi-meeting-reports--meeting_report-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-meeting-reports--meeting_report-"></code></pre>
</div>
<form id="form-PUTapi-meeting-reports--meeting_report-" data-method="PUT" data-path="api/meeting-reports/{meeting_report}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-meeting-reports--meeting_report-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/meeting-reports/{meeting_report}</code></b>
</p>
<p>
<label id="auth-PUTapi-meeting-reports--meeting_report-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-meeting-reports--meeting_report-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>meeting_report</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="meeting_report" data-endpoint="PUTapi-meeting-reports--meeting_report-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-meeting-reports--meeting_report-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-meeting-reports--meeting_report-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-meeting-reports--meeting_report-" data-component="body"  hidden>
<br>

</p>

</form>


## Met des comptes-rendus à la corbeille (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/meeting-reports/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[7,13]}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        7,
        13
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
    'http://localhost/api/meeting-reports/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                7,
                13,
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
<div id="execution-results-POSTapi-meeting-reports-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-meeting-reports-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meeting-reports-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-meeting-reports-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meeting-reports-trash"></code></pre>
</div>
<form id="form-POSTapi-meeting-reports-trash" data-method="POST" data-path="api/meeting-reports/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-meeting-reports-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/meeting-reports/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-meeting-reports-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-meeting-reports-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-meeting-reports-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-meeting-reports-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure des comptes-rendus supprimés (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/meeting-reports/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[4,7]}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        4,
        7
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
    'http://localhost/api/meeting-reports/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                4,
                7,
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
<div id="execution-results-POSTapi-meeting-reports-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-meeting-reports-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meeting-reports-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-meeting-reports-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meeting-reports-restore"></code></pre>
</div>
<form id="form-POSTapi-meeting-reports-restore" data-method="POST" data-path="api/meeting-reports/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-meeting-reports-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/meeting-reports/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-meeting-reports-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-meeting-reports-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-meeting-reports-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-meeting-reports-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement des comptes-rendus (hard delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/meeting-reports/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[17,16]}'

```

```javascript
const url = new URL(
    "http://localhost/api/meeting-reports/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        17,
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
    'http://localhost/api/meeting-reports/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                17,
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
<div id="execution-results-POSTapi-meeting-reports-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-meeting-reports-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meeting-reports-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-meeting-reports-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meeting-reports-delete"></code></pre>
</div>
<form id="form-POSTapi-meeting-reports-delete" data-method="POST" data-path="api/meeting-reports/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-meeting-reports-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/meeting-reports/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-meeting-reports-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-meeting-reports-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-meeting-reports-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-meeting-reports-delete" data-component="body" hidden>
<br>

</p>

</form>



