# Homework


## Afficher la liste des Homeworks

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/homeworksall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":1,"idSection":19,"idClasse":8,"idTeacher":18,"idMatter":17,"deadline":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworksall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 1,
    "idSection": 19,
    "idClasse": 8,
    "idTeacher": 18,
    "idMatter": 17,
    "deadline": "2025-11-22"
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
    'http://localhost/api/homeworksall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 1,
            'idSection' => 19,
            'idClasse' => 8,
            'idTeacher' => 18,
            'idMatter' => 17,
            'deadline' => '2025-11-22',
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
<div id="execution-results-POSTapi-homeworksall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-homeworksall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-homeworksall"></code></pre>
</div>
<div id="execution-error-POSTapi-homeworksall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-homeworksall"></code></pre>
</div>
<form id="form-POSTapi-homeworksall" data-method="POST" data-path="api/homeworksall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-homeworksall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/homeworksall</code></b>
</p>
<p>
<label id="auth-POSTapi-homeworksall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-homeworksall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-homeworksall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-homeworksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-homeworksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-homeworksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-homeworksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>deadline</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="deadline" data-endpoint="POSTapi-homeworksall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Afficher les infos d&#039;un Homework

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/homeworks/quae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/homeworks/quae"
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
    'http://localhost/api/homeworks/quae',
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
<div id="execution-results-GETapi-homeworks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-homeworks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-homeworks--id-"></code></pre>
</div>
<div id="execution-error-GETapi-homeworks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-homeworks--id-"></code></pre>
</div>
<form id="form-GETapi-homeworks--id-" data-method="GET" data-path="api/homeworks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-homeworks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/homeworks/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-homeworks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-homeworks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-homeworks--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un Homework

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/homeworks" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"aperiam","deadline":"maxime","idMatter":17,"idClasse":11,"idTeacher":19}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworks"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "aperiam",
    "deadline": "maxime",
    "idMatter": 17,
    "idClasse": 11,
    "idTeacher": 19
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
    'http://localhost/api/homeworks',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'aperiam',
            'deadline' => 'maxime',
            'idMatter' => 17,
            'idClasse' => 11,
            'idTeacher' => 19,
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
<div id="execution-results-POSTapi-homeworks" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-homeworks"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-homeworks"></code></pre>
</div>
<div id="execution-error-POSTapi-homeworks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-homeworks"></code></pre>
</div>
<form id="form-POSTapi-homeworks" data-method="POST" data-path="api/homeworks" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-homeworks', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/homeworks</code></b>
</p>
<p>
<label id="auth-POSTapi-homeworks" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-homeworks" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-homeworks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>deadline</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="deadline" data-endpoint="POSTapi-homeworks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-homeworks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-homeworks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-homeworks" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un Homework

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/homeworks/rem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"id","deadline":"et","idMatter":17,"idClasse":14,"idTeacher":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworks/rem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "id",
    "deadline": "et",
    "idMatter": 17,
    "idClasse": 14,
    "idTeacher": 20
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
    'http://localhost/api/homeworks/rem',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'id',
            'deadline' => 'et',
            'idMatter' => 17,
            'idClasse' => 14,
            'idTeacher' => 20,
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
<div id="execution-results-PUTapi-homeworks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-homeworks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-homeworks--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-homeworks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-homeworks--id-"></code></pre>
</div>
<form id="form-PUTapi-homeworks--id-" data-method="PUT" data-path="api/homeworks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-homeworks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/homeworks/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-homeworks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-homeworks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-homeworks--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-homeworks--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>deadline</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="deadline" data-endpoint="PUTapi-homeworks--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idMatter" data-endpoint="PUTapi-homeworks--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="PUTapi-homeworks--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="PUTapi-homeworks--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Supprimer un Homework

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/homeworks/velit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/homeworks/velit"
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
    'http://localhost/api/homeworks/velit',
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
<div id="execution-results-DELETEapi-homeworks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-homeworks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-homeworks--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-homeworks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-homeworks--id-"></code></pre>
</div>
<form id="form-DELETEapi-homeworks--id-" data-method="DELETE" data-path="api/homeworks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-homeworks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/homeworks/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-homeworks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-homeworks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-homeworks--id-" data-component="url" required  hidden>
<br>

</p>
</form>



