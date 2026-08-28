# Presence Teacher


## Lister les présences enseignants

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/presenceteachersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSection":5,"type":"teacher","scanPerCourse":false,"savingType":"qr","idTeacher":5,"date":{},"filter_value":"aut"}'

```

```javascript
const url = new URL(
    "http://localhost/api/presenceteachersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSection": 5,
    "type": "teacher",
    "scanPerCourse": false,
    "savingType": "qr",
    "idTeacher": 5,
    "date": {},
    "filter_value": "aut"
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
    'http://localhost/api/presenceteachersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSection' => 5,
            'type' => 'teacher',
            'scanPerCourse' => false,
            'savingType' => 'qr',
            'idTeacher' => 5,
            'date' => [],
            'filter_value' => 'aut',
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
<div id="execution-results-POSTapi-presenceteachersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-presenceteachersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-presenceteachersall"></code></pre>
</div>
<div id="execution-error-POSTapi-presenceteachersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-presenceteachersall"></code></pre>
</div>
<form id="form-POSTapi-presenceteachersall" data-method="POST" data-path="api/presenceteachersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-presenceteachersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/presenceteachersall</code></b>
</p>
<p>
<label id="auth-POSTapi-presenceteachersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-presenceteachersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>
The value must be one of <code>staff</code> or <code>teacher</code>.
</p>
<p>
<b><code>scanPerCourse</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-presenceteachersall" hidden><input type="radio" name="scanPerCourse" value="true" data-endpoint="POSTapi-presenceteachersall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-presenceteachersall" hidden><input type="radio" name="scanPerCourse" value="false" data-endpoint="POSTapi-presenceteachersall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>savingType</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="savingType" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>
The value must be one of <code>manuel</code> or <code>qr</code>.
</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-presenceteachersall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une présence enseignant

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/presenceteachers/autem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/presenceteachers/autem"
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
    'http://localhost/api/presenceteachers/autem',
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
<div id="execution-results-GETapi-presenceteachers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-presenceteachers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-presenceteachers--id-"></code></pre>
</div>
<div id="execution-error-GETapi-presenceteachers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-presenceteachers--id-"></code></pre>
</div>
<form id="form-GETapi-presenceteachers--id-" data-method="GET" data-path="api/presenceteachers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-presenceteachers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/presenceteachers/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-presenceteachers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-presenceteachers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-presenceteachers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Enregistrer une présence manuellement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/presenceteachers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSection":13,"idTeacher":4,"scanPerCourse":false,"type":"teacher","idCourse":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/presenceteachers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSection": 13,
    "idTeacher": 4,
    "scanPerCourse": false,
    "type": "teacher",
    "idCourse": 8
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
    'http://localhost/api/presenceteachers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSection' => 13,
            'idTeacher' => 4,
            'scanPerCourse' => false,
            'type' => 'teacher',
            'idCourse' => 8,
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
<div id="execution-results-POSTapi-presenceteachers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-presenceteachers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-presenceteachers"></code></pre>
</div>
<div id="execution-error-POSTapi-presenceteachers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-presenceteachers"></code></pre>
</div>
<form id="form-POSTapi-presenceteachers" data-method="POST" data-path="api/presenceteachers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-presenceteachers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/presenceteachers</code></b>
</p>
<p>
<label id="auth-POSTapi-presenceteachers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-presenceteachers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-presenceteachers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-presenceteachers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scanPerCourse</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-presenceteachers" hidden><input type="radio" name="scanPerCourse" value="true" data-endpoint="POSTapi-presenceteachers" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-presenceteachers" hidden><input type="radio" name="scanPerCourse" value="false" data-endpoint="POSTapi-presenceteachers" data-component="body" required ><code>false</code></label>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-presenceteachers" data-component="body" required  hidden>
<br>
The value must be one of <code>teacher</code> or <code>staff</code>.
</p>
<p>
<b><code>idCourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCourse" data-endpoint="POSTapi-presenceteachers" data-component="body"  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une présence enseignant

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/presenceteachers/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSection":3,"type":"teacher","scanPerCourse":false,"savingType":"manuel","idTeacher":13,"date":{},"filter_value":"ratione"}'

```

```javascript
const url = new URL(
    "http://localhost/api/presenceteachers/sed"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSection": 3,
    "type": "teacher",
    "scanPerCourse": false,
    "savingType": "manuel",
    "idTeacher": 13,
    "date": {},
    "filter_value": "ratione"
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
    'http://localhost/api/presenceteachers/sed',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSection' => 3,
            'type' => 'teacher',
            'scanPerCourse' => false,
            'savingType' => 'manuel',
            'idTeacher' => 13,
            'date' => [],
            'filter_value' => 'ratione',
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
<div id="execution-results-PUTapi-presenceteachers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-presenceteachers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-presenceteachers--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-presenceteachers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-presenceteachers--id-"></code></pre>
</div>
<form id="form-PUTapi-presenceteachers--id-" data-method="PUT" data-path="api/presenceteachers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-presenceteachers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/presenceteachers/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-presenceteachers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-presenceteachers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-presenceteachers--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>
The value must be one of <code>staff</code> or <code>teacher</code>.
</p>
<p>
<b><code>scanPerCourse</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-presenceteachers--id-" hidden><input type="radio" name="scanPerCourse" value="true" data-endpoint="PUTapi-presenceteachers--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-presenceteachers--id-" hidden><input type="radio" name="scanPerCourse" value="false" data-endpoint="PUTapi-presenceteachers--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>savingType</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="savingType" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>
The value must be one of <code>manuel</code> or <code>qr</code>.
</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="PUTapi-presenceteachers--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer une présence enseignant

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/presenceteachers/saepe" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/presenceteachers/saepe"
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
    'http://localhost/api/presenceteachers/saepe',
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
<div id="execution-results-DELETEapi-presenceteachers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-presenceteachers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-presenceteachers--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-presenceteachers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-presenceteachers--id-"></code></pre>
</div>
<form id="form-DELETEapi-presenceteachers--id-" data-method="DELETE" data-path="api/presenceteachers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-presenceteachers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/presenceteachers/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-presenceteachers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-presenceteachers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-presenceteachers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Calcul du taux horaire d&#039;un enseignant

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/calcultauxhoraire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"date_debut":"2025-11-22T14:46:43+0000","date_fin":"2025-11-22T14:46:43+0000","idTeacher":16}'

```

```javascript
const url = new URL(
    "http://localhost/api/calcultauxhoraire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date_debut": "2025-11-22T14:46:43+0000",
    "date_fin": "2025-11-22T14:46:43+0000",
    "idTeacher": 16
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
    'http://localhost/api/calcultauxhoraire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'date_debut' => '2025-11-22T14:46:43+0000',
            'date_fin' => '2025-11-22T14:46:43+0000',
            'idTeacher' => 16,
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
<div id="execution-results-POSTapi-calcultauxhoraire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-calcultauxhoraire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-calcultauxhoraire"></code></pre>
</div>
<div id="execution-error-POSTapi-calcultauxhoraire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-calcultauxhoraire"></code></pre>
</div>
<form id="form-POSTapi-calcultauxhoraire" data-method="POST" data-path="api/calcultauxhoraire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-calcultauxhoraire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/calcultauxhoraire</code></b>
</p>
<p>
<label id="auth-POSTapi-calcultauxhoraire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-calcultauxhoraire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>date_debut</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_debut" data-endpoint="POSTapi-calcultauxhoraire" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_fin</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_fin" data-endpoint="POSTapi-calcultauxhoraire" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-calcultauxhoraire" data-component="body" required  hidden>
<br>

</p>

</form>



