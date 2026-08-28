# School Year


## Afficher les SchoolYear

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/academic-yearsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":5,"nbreItems":3,"filter_value":"ratione","startDate":"2025-11-22T14:46:32+0000","endDate":"2025-11-22T14:46:32+0000","trashed":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/academic-yearsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 5,
    "nbreItems": 3,
    "filter_value": "ratione",
    "startDate": "2025-11-22T14:46:32+0000",
    "endDate": "2025-11-22T14:46:32+0000",
    "trashed": false
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
    'http://localhost/api/academic-yearsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 5,
            'nbreItems' => 3,
            'filter_value' => 'ratione',
            'startDate' => '2025-11-22T14:46:32+0000',
            'endDate' => '2025-11-22T14:46:32+0000',
            'trashed' => false,
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
<div id="execution-results-POSTapi-academic-yearsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-academic-yearsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-academic-yearsall"></code></pre>
</div>
<div id="execution-error-POSTapi-academic-yearsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-academic-yearsall"></code></pre>
</div>
<form id="form-POSTapi-academic-yearsall" data-method="POST" data-path="api/academic-yearsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-academic-yearsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/academic-yearsall</code></b>
</p>
<p>
<label id="auth-POSTapi-academic-yearsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-academic-yearsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-academic-yearsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-academic-yearsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-academic-yearsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="startDate" data-endpoint="POSTapi-academic-yearsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="endDate" data-endpoint="POSTapi-academic-yearsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-academic-yearsall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-academic-yearsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-academic-yearsall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-academic-yearsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Ajouter un SchoolYear

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/academic-years" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"sed","start_date":"2025-11-22T14:46:32+0000","end_date":"2025-11-22T14:46:32+0000","previousAcademicYearId":19}'

```

```javascript
const url = new URL(
    "http://localhost/api/academic-years"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "sed",
    "start_date": "2025-11-22T14:46:32+0000",
    "end_date": "2025-11-22T14:46:32+0000",
    "previousAcademicYearId": 19
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
    'http://localhost/api/academic-years',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'sed',
            'start_date' => '2025-11-22T14:46:32+0000',
            'end_date' => '2025-11-22T14:46:32+0000',
            'previousAcademicYearId' => 19,
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
<div id="execution-results-POSTapi-academic-years" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-academic-years"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-academic-years"></code></pre>
</div>
<div id="execution-error-POSTapi-academic-years" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-academic-years"></code></pre>
</div>
<form id="form-POSTapi-academic-years" data-method="POST" data-path="api/academic-years" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-academic-years', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/academic-years</code></b>
</p>
<p>
<label id="auth-POSTapi-academic-years" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-academic-years" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-academic-years" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="start_date" data-endpoint="POSTapi-academic-years" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date" data-endpoint="POSTapi-academic-years" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>previousAcademicYearId</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="previousAcademicYearId" data-endpoint="POSTapi-academic-years" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les infos d&#039;un SchoolYear

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/academic-years/voluptas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/academic-years/voluptas"
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
    'http://localhost/api/academic-years/voluptas',
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
<div id="execution-results-GETapi-academic-years--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-academic-years--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-academic-years--id-"></code></pre>
</div>
<div id="execution-error-GETapi-academic-years--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-academic-years--id-"></code></pre>
</div>
<form id="form-GETapi-academic-years--id-" data-method="GET" data-path="api/academic-years/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-academic-years--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/academic-years/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-academic-years--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-academic-years--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-academic-years--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un SchoolYear

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/academic-years/laboriosam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":{},"start_date":"2025-11-22T14:46:32+0000","end_date":"2025-11-22T14:46:32+0000","previousAcademicYearId":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/academic-years/laboriosam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": {},
    "start_date": "2025-11-22T14:46:32+0000",
    "end_date": "2025-11-22T14:46:32+0000",
    "previousAcademicYearId": 4
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
    'http://localhost/api/academic-years/laboriosam',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => [],
            'start_date' => '2025-11-22T14:46:32+0000',
            'end_date' => '2025-11-22T14:46:32+0000',
            'previousAcademicYearId' => 4,
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
<div id="execution-results-PUTapi-academic-years--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-academic-years--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-academic-years--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-academic-years--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-academic-years--id-"></code></pre>
</div>
<form id="form-PUTapi-academic-years--id-" data-method="PUT" data-path="api/academic-years/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-academic-years--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/academic-years/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-academic-years--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-academic-years--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-academic-years--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-academic-years--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date" data-endpoint="PUTapi-academic-years--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date" data-endpoint="PUTapi-academic-years--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>previousAcademicYearId</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="previousAcademicYearId" data-endpoint="PUTapi-academic-years--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer un SchoolYear

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/academic-years/optio" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/academic-years/optio"
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
    'http://localhost/api/academic-years/optio',
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
<div id="execution-results-DELETEapi-academic-years--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-academic-years--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-academic-years--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-academic-years--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-academic-years--id-"></code></pre>
</div>
<form id="form-DELETEapi-academic-years--id-" data-method="DELETE" data-path="api/academic-years/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-academic-years--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/academic-years/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-academic-years--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-academic-years--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-academic-years--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Archiver une ou plusieurs années scolaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/academic-years/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[16,15]}'

```

```javascript
const url = new URL(
    "http://localhost/api/academic-years/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        16,
        15
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
    'http://localhost/api/academic-years/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                16,
                15,
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
<div id="execution-results-POSTapi-academic-years-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-academic-years-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-academic-years-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-academic-years-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-academic-years-trash"></code></pre>
</div>
<form id="form-POSTapi-academic-years-trash" data-method="POST" data-path="api/academic-years/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-academic-years-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/academic-years/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-academic-years-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-academic-years-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-academic-years-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-academic-years-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer une ou plusieurs années scolaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/academic-years/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[20,6]}'

```

```javascript
const url = new URL(
    "http://localhost/api/academic-years/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        20,
        6
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
    'http://localhost/api/academic-years/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                20,
                6,
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
<div id="execution-results-POSTapi-academic-years-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-academic-years-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-academic-years-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-academic-years-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-academic-years-restore"></code></pre>
</div>
<form id="form-POSTapi-academic-years-restore" data-method="POST" data-path="api/academic-years/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-academic-years-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/academic-years/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-academic-years-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-academic-years-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-academic-years-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-academic-years-restore" data-component="body" hidden>
<br>

</p>

</form>



