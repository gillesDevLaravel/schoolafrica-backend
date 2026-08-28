# Teacher Observation


## Afficher la liste des observations des enseignants

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/teacherobservationsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":1,"idSection":14,"idAssessment":10,"idStudent":2,"idClasse":8,"idTeacher":15,"nbreItems":20,"pageItems":11,"filter_value":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/teacherobservationsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 1,
    "idSection": 14,
    "idAssessment": 10,
    "idStudent": 2,
    "idClasse": 8,
    "idTeacher": 15,
    "nbreItems": 20,
    "pageItems": 11,
    "filter_value": {}
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
    'http://localhost/api/teacherobservationsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 1,
            'idSection' => 14,
            'idAssessment' => 10,
            'idStudent' => 2,
            'idClasse' => 8,
            'idTeacher' => 15,
            'nbreItems' => 20,
            'pageItems' => 11,
            'filter_value' => [],
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
<div id="execution-results-POSTapi-teacherobservationsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-teacherobservationsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacherobservationsall"></code></pre>
</div>
<div id="execution-error-POSTapi-teacherobservationsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacherobservationsall"></code></pre>
</div>
<form id="form-POSTapi-teacherobservationsall" data-method="POST" data-path="api/teacherobservationsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacherobservationsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/teacherobservationsall</code></b>
</p>
<p>
<label id="auth-POSTapi-teacherobservationsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-teacherobservationsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-teacherobservationsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-teacherobservationsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une observation

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/teacherobservations/tempora" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/teacherobservations/tempora"
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
    'http://localhost/api/teacherobservations/tempora',
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
<div id="execution-results-GETapi-teacherobservations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-teacherobservations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teacherobservations--id-"></code></pre>
</div>
<div id="execution-error-GETapi-teacherobservations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teacherobservations--id-"></code></pre>
</div>
<form id="form-GETapi-teacherobservations--id-" data-method="GET" data-path="api/teacherobservations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-teacherobservations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/teacherobservations/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-teacherobservations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-teacherobservations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-teacherobservations--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une observation

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/teacherobservations" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"description":"nulla","answer":{},"idAssessment":8,"idStudent":18,"idClasse":1,"idSchool":4,"idSection":12,"idTeacher":18}'

```

```javascript
const url = new URL(
    "http://localhost/api/teacherobservations"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "nulla",
    "answer": {},
    "idAssessment": 8,
    "idStudent": 18,
    "idClasse": 1,
    "idSchool": 4,
    "idSection": 12,
    "idTeacher": 18
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
    'http://localhost/api/teacherobservations',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'description' => 'nulla',
            'answer' => [],
            'idAssessment' => 8,
            'idStudent' => 18,
            'idClasse' => 1,
            'idSchool' => 4,
            'idSection' => 12,
            'idTeacher' => 18,
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
<div id="execution-results-POSTapi-teacherobservations" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-teacherobservations"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacherobservations"></code></pre>
</div>
<div id="execution-error-POSTapi-teacherobservations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacherobservations"></code></pre>
</div>
<form id="form-POSTapi-teacherobservations" data-method="POST" data-path="api/teacherobservations" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacherobservations', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/teacherobservations</code></b>
</p>
<p>
<label id="auth-POSTapi-teacherobservations" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-teacherobservations" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-teacherobservations" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="answer" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-teacherobservations" data-component="body"  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une observation

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/teacherobservations/placeat" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"description":"quas","answer":{},"idAssessment":18,"idStudent":19,"idClasse":8,"idSchool":10,"idSection":7,"idTeacher":14}'

```

```javascript
const url = new URL(
    "http://localhost/api/teacherobservations/placeat"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "quas",
    "answer": {},
    "idAssessment": 18,
    "idStudent": 19,
    "idClasse": 8,
    "idSchool": 10,
    "idSection": 7,
    "idTeacher": 14
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
    'http://localhost/api/teacherobservations/placeat',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'description' => 'quas',
            'answer' => [],
            'idAssessment' => 18,
            'idStudent' => 19,
            'idClasse' => 8,
            'idSchool' => 10,
            'idSection' => 7,
            'idTeacher' => 14,
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
<div id="execution-results-PUTapi-teacherobservations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-teacherobservations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-teacherobservations--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-teacherobservations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-teacherobservations--id-"></code></pre>
</div>
<form id="form-PUTapi-teacherobservations--id-" data-method="PUT" data-path="api/teacherobservations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-teacherobservations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/teacherobservations/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-teacherobservations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-teacherobservations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-teacherobservations--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-teacherobservations--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="answer" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="PUTapi-teacherobservations--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer une observation

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/teacherobservations/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/teacherobservations/et"
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
    'http://localhost/api/teacherobservations/et',
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
<div id="execution-results-DELETEapi-teacherobservations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-teacherobservations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-teacherobservations--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-teacherobservations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-teacherobservations--id-"></code></pre>
</div>
<form id="form-DELETEapi-teacherobservations--id-" data-method="DELETE" data-path="api/teacherobservations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-teacherobservations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/teacherobservations/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-teacherobservations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-teacherobservations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-teacherobservations--id-" data-component="url" required  hidden>
<br>

</p>
</form>



