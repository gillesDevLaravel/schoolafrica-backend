# Documents


## Générer certificats de scolarité

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/generer-certificat-scolarite" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":17,"route":"exercitationem","idStudent":2,"idAcademicYear":18}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/generer-certificat-scolarite"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 17,
    "route": "exercitationem",
    "idStudent": 2,
    "idAcademicYear": 18
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
    'http://localhost/api/users/generer-certificat-scolarite',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 17,
            'route' => 'exercitationem',
            'idStudent' => 2,
            'idAcademicYear' => 18,
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
<div id="execution-results-POSTapi-users-generer-certificat-scolarite" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-generer-certificat-scolarite"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-generer-certificat-scolarite"></code></pre>
</div>
<div id="execution-error-POSTapi-users-generer-certificat-scolarite" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-generer-certificat-scolarite"></code></pre>
</div>
<form id="form-POSTapi-users-generer-certificat-scolarite" data-method="POST" data-path="api/users/generer-certificat-scolarite" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-generer-certificat-scolarite', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/generer-certificat-scolarite</code></b>
</p>
<p>
<label id="auth-POSTapi-users-generer-certificat-scolarite" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-generer-certificat-scolarite" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-users-generer-certificat-scolarite" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-users-generer-certificat-scolarite" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-users-generer-certificat-scolarite" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-users-generer-certificat-scolarite" data-component="body"  hidden>
<br>

</p>

</form>


## Générer carte(s) scolaire(s)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/carte-scolaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":7,"route":"commodi","idStudent":16,"idAcademicYear":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/carte-scolaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 7,
    "route": "commodi",
    "idStudent": 16,
    "idAcademicYear": 2
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
    'http://localhost/api/users/carte-scolaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 7,
            'route' => 'commodi',
            'idStudent' => 16,
            'idAcademicYear' => 2,
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
<div id="execution-results-POSTapi-users-carte-scolaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-carte-scolaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-carte-scolaire"></code></pre>
</div>
<div id="execution-error-POSTapi-users-carte-scolaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-carte-scolaire"></code></pre>
</div>
<form id="form-POSTapi-users-carte-scolaire" data-method="POST" data-path="api/users/carte-scolaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-carte-scolaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/carte-scolaire</code></b>
</p>
<p>
<label id="auth-POSTapi-users-carte-scolaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-carte-scolaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-users-carte-scolaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-users-carte-scolaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-users-carte-scolaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-users-carte-scolaire" data-component="body"  hidden>
<br>

</p>

</form>


## Générer la liste des élèves de la classe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-students" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":10,"idSection":5,"idClasse":7}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-students"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 10,
    "idSection": 5,
    "idClasse": 7
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
    'http://localhost/api/documents/list-students',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 10,
            'idSection' => 5,
            'idClasse' => 7,
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
<div id="execution-results-POSTapi-documents-list-students" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-students"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-students"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-students" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-students"></code></pre>
</div>
<form id="form-POSTapi-documents-list-students" data-method="POST" data-path="api/documents/list-students" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-students', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-students</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-students" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-students" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-students" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-students" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-students" data-component="body"  hidden>
<br>

</p>

</form>


## Générer la liste PDF de parents avec leurs enfants (pour ceux qui en ont)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-parents" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":10,"idSection":17,"idClasse":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-parents"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 10,
    "idSection": 17,
    "idClasse": 13
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
    'http://localhost/api/documents/list-parents',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 10,
            'idSection' => 17,
            'idClasse' => 13,
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
<div id="execution-results-POSTapi-documents-list-parents" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-parents"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-parents"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-parents" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-parents"></code></pre>
</div>
<form id="form-POSTapi-documents-list-parents" data-method="POST" data-path="api/documents/list-parents" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-parents', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-parents</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-parents" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-parents" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-parents" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-parents" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-parents" data-component="body"  hidden>
<br>

</p>

</form>


## Générer un document PDF pour la liste des pensions Users

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-pensions-users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":17,"idSection":14,"date_start":"2025-11-22T14:46:46+0000","date_end":"2025-11-22T14:46:46+0000","filter_value":"aut","payment_mode":"modi"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-pensions-users"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 17,
    "idSection": 14,
    "date_start": "2025-11-22T14:46:46+0000",
    "date_end": "2025-11-22T14:46:46+0000",
    "filter_value": "aut",
    "payment_mode": "modi"
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
    'http://localhost/api/documents/list-pensions-users',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 17,
            'idSection' => 14,
            'date_start' => '2025-11-22T14:46:46+0000',
            'date_end' => '2025-11-22T14:46:46+0000',
            'filter_value' => 'aut',
            'payment_mode' => 'modi',
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
<div id="execution-results-POSTapi-documents-list-pensions-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-pensions-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-pensions-users"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-pensions-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-pensions-users"></code></pre>
</div>
<form id="form-POSTapi-documents-list-pensions-users" data-method="POST" data-path="api/documents/list-pensions-users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-pensions-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-pensions-users</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-pensions-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-pensions-users" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-documents-list-pensions-users" data-component="body"  hidden>
<br>

</p>

</form>


## Générer un document PDF pour la liste des fees Users

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-fees-users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":19,"idSection":9,"idFee":14,"date_start":"2025-11-22T14:46:46+0000","date_end":"2025-11-22T14:46:46+0000","filter_value":"architecto","payment_mode":"temporibus"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-fees-users"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 19,
    "idSection": 9,
    "idFee": 14,
    "date_start": "2025-11-22T14:46:46+0000",
    "date_end": "2025-11-22T14:46:46+0000",
    "filter_value": "architecto",
    "payment_mode": "temporibus"
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
    'http://localhost/api/documents/list-fees-users',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 19,
            'idSection' => 9,
            'idFee' => 14,
            'date_start' => '2025-11-22T14:46:46+0000',
            'date_end' => '2025-11-22T14:46:46+0000',
            'filter_value' => 'architecto',
            'payment_mode' => 'temporibus',
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
<div id="execution-results-POSTapi-documents-list-fees-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-fees-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-fees-users"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-fees-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-fees-users"></code></pre>
</div>
<form id="form-POSTapi-documents-list-fees-users" data-method="POST" data-path="api/documents/list-fees-users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-fees-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-fees-users</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-fees-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-fees-users" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-fees-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-documents-list-fees-users" data-component="body"  hidden>
<br>

</p>

</form>


## Générer la liste PDF des enseignants

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-teachers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":15,"idSection":2,"idClasse":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-teachers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 15,
    "idSection": 2,
    "idClasse": 20
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
    'http://localhost/api/documents/list-teachers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 15,
            'idSection' => 2,
            'idClasse' => 20,
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
<div id="execution-results-POSTapi-documents-list-teachers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-teachers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-teachers"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-teachers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-teachers"></code></pre>
</div>
<form id="form-POSTapi-documents-list-teachers" data-method="POST" data-path="api/documents/list-teachers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-teachers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-teachers</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-teachers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-teachers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-teachers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-teachers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-teachers" data-component="body"  hidden>
<br>

</p>

</form>


## Générer la liste PDF du Staff

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-staff" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":9,"idSection":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-staff"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 9,
    "idSection": 4
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
    'http://localhost/api/documents/list-staff',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 9,
            'idSection' => 4,
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
<div id="execution-results-POSTapi-documents-list-staff" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-staff"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-staff"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-staff" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-staff"></code></pre>
</div>
<form id="form-POSTapi-documents-list-staff" data-method="POST" data-path="api/documents/list-staff" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-staff', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-staff</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-staff" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-staff" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-staff" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-staff" data-component="body"  hidden>
<br>

</p>

</form>


## Liste PDF des customers

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-customers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-customers"
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
    'http://localhost/api/documents/list-customers',
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
<div id="execution-results-POSTapi-documents-list-customers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-customers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-customers"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-customers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-customers"></code></pre>
</div>
<form id="form-POSTapi-documents-list-customers" data-method="POST" data-path="api/documents/list-customers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-customers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-customers</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-customers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-customers" data-component="header"></label>
</p>
</form>


## Liste PDF des invoices

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-invoices" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":2,"idSection":15,"statut":"unpaid","mode":"inventore","idTypeInvoice":20,"idProduct":18,"idUser":4,"date_start":"2025-11-22T14:46:46+0000","date_end":"2025-11-22T14:46:46+0000","typeUser":"adipisci","pageItems":5,"nbreItems":12}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-invoices"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 2,
    "idSection": 15,
    "statut": "unpaid",
    "mode": "inventore",
    "idTypeInvoice": 20,
    "idProduct": 18,
    "idUser": 4,
    "date_start": "2025-11-22T14:46:46+0000",
    "date_end": "2025-11-22T14:46:46+0000",
    "typeUser": "adipisci",
    "pageItems": 5,
    "nbreItems": 12
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
    'http://localhost/api/documents/list-invoices',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 2,
            'idSection' => 15,
            'statut' => 'unpaid',
            'mode' => 'inventore',
            'idTypeInvoice' => 20,
            'idProduct' => 18,
            'idUser' => 4,
            'date_start' => '2025-11-22T14:46:46+0000',
            'date_end' => '2025-11-22T14:46:46+0000',
            'typeUser' => 'adipisci',
            'pageItems' => 5,
            'nbreItems' => 12,
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
<div id="execution-results-POSTapi-documents-list-invoices" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-invoices"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-invoices"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-invoices"></code></pre>
</div>
<form id="form-POSTapi-documents-list-invoices" data-method="POST" data-path="api/documents/list-invoices" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-invoices', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-invoices</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-invoices" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-invoices" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>
The value must be one of <code>paid</code> or <code>unpaid</code>.
</p>
<p>
<b><code>mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mode" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeInvoice</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeInvoice" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idProduct</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idProduct" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>typeUser</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="typeUser" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-documents-list-invoices" data-component="body"  hidden>
<br>

</p>

</form>


## Liste des students d&#039;une classe avec les assessments

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-users-assessments" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-users-assessments"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 11
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
    'http://localhost/api/documents/list-users-assessments',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 11,
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
<div id="execution-results-POSTapi-documents-list-users-assessments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-users-assessments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-users-assessments"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-users-assessments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-users-assessments"></code></pre>
</div>
<form id="form-POSTapi-documents-list-users-assessments" data-method="POST" data-path="api/documents/list-users-assessments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-users-assessments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-users-assessments</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-users-assessments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-users-assessments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-users-assessments" data-component="body" required  hidden>
<br>

</p>

</form>


## listUsersWithAssessmentsByMatter

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-users-assessments-by-matter" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAcademicYear":9,"idClasse":7,"idTrimestre":3,"idAssessment":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-users-assessments-by-matter"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAcademicYear": 9,
    "idClasse": 7,
    "idTrimestre": 3,
    "idAssessment": 20
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
    'http://localhost/api/documents/list-users-assessments-by-matter',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAcademicYear' => 9,
            'idClasse' => 7,
            'idTrimestre' => 3,
            'idAssessment' => 20,
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
<div id="execution-results-POSTapi-documents-list-users-assessments-by-matter" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-users-assessments-by-matter"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-users-assessments-by-matter"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-users-assessments-by-matter" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-users-assessments-by-matter"></code></pre>
</div>
<form id="form-POSTapi-documents-list-users-assessments-by-matter" data-method="POST" data-path="api/documents/list-users-assessments-by-matter" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-users-assessments-by-matter', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-users-assessments-by-matter</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-users-assessments-by-matter" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-users-assessments-by-matter" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-documents-list-users-assessments-by-matter" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-users-assessments-by-matter" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-documents-list-users-assessments-by-matter" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-documents-list-users-assessments-by-matter" data-component="body" required  hidden>
<br>

</p>

</form>


## listUsersWithAssessmentsByMatterGroup

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-users-assessments-by-matter-group" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":15,"idTrimestre":19,"idMatterGroup":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-users-assessments-by-matter-group"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 15,
    "idTrimestre": 19,
    "idMatterGroup": 13
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
    'http://localhost/api/documents/list-users-assessments-by-matter-group',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 15,
            'idTrimestre' => 19,
            'idMatterGroup' => 13,
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
<div id="execution-results-POSTapi-documents-list-users-assessments-by-matter-group" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-users-assessments-by-matter-group"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-users-assessments-by-matter-group"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-users-assessments-by-matter-group" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-users-assessments-by-matter-group"></code></pre>
</div>
<form id="form-POSTapi-documents-list-users-assessments-by-matter-group" data-method="POST" data-path="api/documents/list-users-assessments-by-matter-group" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-users-assessments-by-matter-group', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-users-assessments-by-matter-group</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-users-assessments-by-matter-group" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-users-assessments-by-matter-group" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-users-assessments-by-matter-group" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-documents-list-users-assessments-by-matter-group" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatterGroup</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idMatterGroup" data-endpoint="POSTapi-documents-list-users-assessments-by-matter-group" data-component="body" required  hidden>
<br>

</p>

</form>


## api/documents/list-{category}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-enim" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":6,"idSection":8,"nameTranche":"ut","idClasse":12,"nbreItems":10,"pageItems":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-enim"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 6,
    "idSection": 8,
    "nameTranche": "ut",
    "idClasse": 12,
    "nbreItems": 10,
    "pageItems": 1
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
    'http://localhost/api/documents/list-enim',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 6,
            'idSection' => 8,
            'nameTranche' => 'ut',
            'idClasse' => 12,
            'nbreItems' => 10,
            'pageItems' => 1,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (404):

```json
{
    "message": "",
    "exception": "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException",
    "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/AbstractRouteCollection.php",
    "line": 43,
    "trace": [
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/RouteCollection.php",
            "line": 162,
            "function": "handleMatchedRoute",
            "class": "Illuminate\\Routing\\AbstractRouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 639,
            "function": "match",
            "class": "Illuminate\\Routing\\RouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 628,
            "function": "findRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 617,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 165,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 63,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php",
            "line": 52,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fruitcake\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 140,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 109,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 324,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 305,
            "function": "callLaravelOrLumenRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 76,
            "function": "makeApiCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 51,
            "function": "makeResponseCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 41,
            "function": "makeResponseCallIfEnabledAndNoSuccessResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 236,
            "function": "__invoke",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 172,
            "function": "iterateThroughStrategies",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 127,
            "function": "fetchResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 119,
            "function": "processRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 73,
            "function": "processRoutes",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 36,
            "function": "handle",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php",
            "line": 37,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 93,
            "function": "unwrapIfClosure",
            "class": "Illuminate\\Container\\Util",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 37,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 596,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 134,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 298,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 121,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 1040,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 301,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 171,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 93,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 129,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```
<div id="execution-results-POSTapi-documents-list--category-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list--category-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list--category-"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list--category-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list--category-"></code></pre>
</div>
<form id="form-POSTapi-documents-list--category-" data-method="POST" data-path="api/documents/list-{category}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list--category-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-{category}</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list--category-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list--category-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>category</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="category" data-endpoint="POSTapi-documents-list--category-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-documents-list--category-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-documents-list--category-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nameTranche</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nameTranche" data-endpoint="POSTapi-documents-list--category-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list--category-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-documents-list--category-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-documents-list--category-" data-component="body"  hidden>
<br>

</p>

</form>


## Undocumented function

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-pdf-possimus-feeusers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"iusto","idFee":"consequuntur","idSection":{},"idClasse":{},"idLevel":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-pdf-possimus-feeusers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "iusto",
    "idFee": "consequuntur",
    "idSection": {},
    "idClasse": {},
    "idLevel": {}
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
    'http://localhost/api/documents/list-pdf-possimus-feeusers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'iusto',
            'idFee' => 'consequuntur',
            'idSection' => [],
            'idClasse' => [],
            'idLevel' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (404):

```json
{
    "message": "",
    "exception": "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException",
    "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/AbstractRouteCollection.php",
    "line": 43,
    "trace": [
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/RouteCollection.php",
            "line": 162,
            "function": "handleMatchedRoute",
            "class": "Illuminate\\Routing\\AbstractRouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 639,
            "function": "match",
            "class": "Illuminate\\Routing\\RouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 628,
            "function": "findRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 617,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 165,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 63,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php",
            "line": 52,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fruitcake\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 140,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 109,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 324,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 305,
            "function": "callLaravelOrLumenRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 76,
            "function": "makeApiCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 51,
            "function": "makeResponseCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 41,
            "function": "makeResponseCallIfEnabledAndNoSuccessResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 236,
            "function": "__invoke",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 172,
            "function": "iterateThroughStrategies",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 127,
            "function": "fetchResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 119,
            "function": "processRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 73,
            "function": "processRoutes",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 36,
            "function": "handle",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php",
            "line": 37,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 93,
            "function": "unwrapIfClosure",
            "class": "Illuminate\\Container\\Util",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 37,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 596,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 134,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 298,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 121,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 1040,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 301,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 171,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 93,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 129,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```
<div id="execution-results-POSTapi-documents-list-pdf--type--feeusers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-pdf--type--feeusers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-pdf--type--feeusers"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-pdf--type--feeusers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-pdf--type--feeusers"></code></pre>
</div>
<form id="form-POSTapi-documents-list-pdf--type--feeusers" data-method="POST" data-path="api/documents/list-pdf-{type}-feeusers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-pdf--type--feeusers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-pdf-{type}-feeusers</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-pdf--type--feeusers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idFee" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idClasse" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idLevel" data-endpoint="POSTapi-documents-list-pdf--type--feeusers" data-component="body"  hidden>
<br>

</p>

</form>


## api/documents/generer-tableau-honneur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/generer-tableau-honneur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":10,"idClasse":16,"idTrimestre":17,"idOptionLevel":15,"moyenne":5.02529659,"route":"unde"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/generer-tableau-honneur"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 10,
    "idClasse": 16,
    "idTrimestre": 17,
    "idOptionLevel": 15,
    "moyenne": 5.02529659,
    "route": "unde"
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
    'http://localhost/api/documents/generer-tableau-honneur',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 10,
            'idClasse' => 16,
            'idTrimestre' => 17,
            'idOptionLevel' => 15,
            'moyenne' => 5.02529659,
            'route' => 'unde',
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
<div id="execution-results-POSTapi-documents-generer-tableau-honneur" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-generer-tableau-honneur"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-generer-tableau-honneur"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-generer-tableau-honneur" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-generer-tableau-honneur"></code></pre>
</div>
<form id="form-POSTapi-documents-generer-tableau-honneur" data-method="POST" data-path="api/documents/generer-tableau-honneur" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-generer-tableau-honneur', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/generer-tableau-honneur</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-generer-tableau-honneur" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>moyenne</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="moyenne" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-documents-generer-tableau-honneur" data-component="body"  hidden>
<br>

</p>

</form>



