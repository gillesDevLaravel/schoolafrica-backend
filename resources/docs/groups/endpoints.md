# Endpoints


## api/users-reset-password

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users-reset-password" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":"sunt","password":"occaecati"}'

```

```javascript
const url = new URL(
    "http://localhost/api/users-reset-password"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": "sunt",
    "password": "occaecati"
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
    'http://localhost/api/users-reset-password',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 'sunt',
            'password' => 'occaecati',
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
<div id="execution-results-POSTapi-users-reset-password" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-reset-password"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-reset-password"></code></pre>
</div>
<div id="execution-error-POSTapi-users-reset-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-reset-password"></code></pre>
</div>
<form id="form-POSTapi-users-reset-password" data-method="POST" data-path="api/users-reset-password" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-reset-password', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users-reset-password</code></b>
</p>
<p>
<label id="auth-POSTapi-users-reset-password" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-reset-password" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idUser" data-endpoint="POSTapi-users-reset-password" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-users-reset-password" data-component="body" required  hidden>
<br>

</p>

</form>


## Obtenir la moyenne d&#039;un élève sur les différentes séquences

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/moyenne-student" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":13,"idStudent":4,"idAssessmentType":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/moyenne-student"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 13,
    "idStudent": 4,
    "idAssessmentType": 1
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
    'http://localhost/api/moyenne-student',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 13,
            'idStudent' => 4,
            'idAssessmentType' => 1,
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
<div id="execution-results-POSTapi-moyenne-student" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-moyenne-student"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-moyenne-student"></code></pre>
</div>
<div id="execution-error-POSTapi-moyenne-student" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-moyenne-student"></code></pre>
</div>
<form id="form-POSTapi-moyenne-student" data-method="POST" data-path="api/moyenne-student" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-moyenne-student', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/moyenne-student</code></b>
</p>
<p>
<label id="auth-POSTapi-moyenne-student" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-moyenne-student" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-moyenne-student" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-moyenne-student" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-moyenne-student" data-component="body" required  hidden>
<br>

</p>

</form>


## Effectuer un tranfert d&#039;élève et générer un PDF

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/certificat-transfert" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":12,"country":"quia","route":"unde","academic_year":"et","reason":"voluptas","date":"2025-11-22T14:46:46+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/certificat-transfert"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 12,
    "country": "quia",
    "route": "unde",
    "academic_year": "et",
    "reason": "voluptas",
    "date": "2025-11-22T14:46:46+0000"
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
    'http://localhost/api/documents/certificat-transfert',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 12,
            'country' => 'quia',
            'route' => 'unde',
            'academic_year' => 'et',
            'reason' => 'voluptas',
            'date' => '2025-11-22T14:46:46+0000',
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
<div id="execution-results-POSTapi-documents-certificat-transfert" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-certificat-transfert"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-certificat-transfert"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-certificat-transfert" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-certificat-transfert"></code></pre>
</div>
<form id="form-POSTapi-documents-certificat-transfert" data-method="POST" data-path="api/documents/certificat-transfert" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-certificat-transfert', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/certificat-transfert</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-certificat-transfert" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-certificat-transfert" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>country</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>academic_year</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="academic_year" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-documents-certificat-transfert" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## api/documents/infos-generales-ecole

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/infos-generales-ecole" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"ut","idSection":"sed","idTrimestre":"sed","route":"nemo"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/infos-generales-ecole"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "ut",
    "idSection": "sed",
    "idTrimestre": "sed",
    "route": "nemo"
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
    'http://localhost/api/documents/infos-generales-ecole',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'ut',
            'idSection' => 'sed',
            'idTrimestre' => 'sed',
            'route' => 'nemo',
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
<div id="execution-results-POSTapi-documents-infos-generales-ecole" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-infos-generales-ecole"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-infos-generales-ecole"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-infos-generales-ecole" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-infos-generales-ecole"></code></pre>
</div>
<form id="form-POSTapi-documents-infos-generales-ecole" data-method="POST" data-path="api/documents/infos-generales-ecole" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-infos-generales-ecole', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/infos-generales-ecole</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-infos-generales-ecole" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-infos-generales-ecole" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-documents-infos-generales-ecole" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-documents-infos-generales-ecole" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idTrimestre" data-endpoint="POSTapi-documents-infos-generales-ecole" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-documents-infos-generales-ecole" data-component="body" required  hidden>
<br>

</p>

</form>


## Lister dans un PDF les réponses d&#039;un étudiant à un ou plusieurs évaluations d&#039;une séquence

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/list-student-answers-on-assessment" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":15,"idStudent":4,"idAssessmentType":17,"idAssessment":2,"route":"sunt"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/list-student-answers-on-assessment"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 15,
    "idStudent": 4,
    "idAssessmentType": 17,
    "idAssessment": 2,
    "route": "sunt"
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
    'http://localhost/api/documents/list-student-answers-on-assessment',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 15,
            'idStudent' => 4,
            'idAssessmentType' => 17,
            'idAssessment' => 2,
            'route' => 'sunt',
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
<div id="execution-results-POSTapi-documents-list-student-answers-on-assessment" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-list-student-answers-on-assessment"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-list-student-answers-on-assessment"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-list-student-answers-on-assessment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-list-student-answers-on-assessment"></code></pre>
</div>
<form id="form-POSTapi-documents-list-student-answers-on-assessment" data-method="POST" data-path="api/documents/list-student-answers-on-assessment" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-list-student-answers-on-assessment', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/list-student-answers-on-assessment</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-list-student-answers-on-assessment" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-documents-list-student-answers-on-assessment" data-component="body"  hidden>
<br>

</p>

</form>


## Lister les projets non supprimés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/projectsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":13,"nbreItems":17,"filter_value":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/api/projectsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 13,
    "nbreItems": 17,
    "filter_value": "qui"
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
    'http://localhost/api/projectsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 13,
            'nbreItems' => 17,
            'filter_value' => 'qui',
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
<div id="execution-results-POSTapi-projectsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-projectsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-projectsall"></code></pre>
</div>
<div id="execution-error-POSTapi-projectsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-projectsall"></code></pre>
</div>
<form id="form-POSTapi-projectsall" data-method="POST" data-path="api/projectsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-projectsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/projectsall</code></b>
</p>
<p>
<label id="auth-POSTapi-projectsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-projectsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-projectsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-projectsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-projectsall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer une nouveau projet

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/projects" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"veritatis","description":"nam","start_date":"2025-11-22T14:46:46+0000","end_date":"2025-11-22T14:46:46+0000","users":["qui"]}'

```

```javascript
const url = new URL(
    "http://localhost/api/projects"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "veritatis",
    "description": "nam",
    "start_date": "2025-11-22T14:46:46+0000",
    "end_date": "2025-11-22T14:46:46+0000",
    "users": [
        "qui"
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
    'http://localhost/api/projects',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'veritatis',
            'description' => 'nam',
            'start_date' => '2025-11-22T14:46:46+0000',
            'end_date' => '2025-11-22T14:46:46+0000',
            'users' => [
                'qui',
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
<div id="execution-results-POSTapi-projects" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-projects"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-projects"></code></pre>
</div>
<div id="execution-error-POSTapi-projects" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-projects"></code></pre>
</div>
<form id="form-POSTapi-projects" data-method="POST" data-path="api/projects" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-projects', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/projects</code></b>
</p>
<p>
<label id="auth-POSTapi-projects" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-projects" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-projects" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-projects" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="start_date" data-endpoint="POSTapi-projects" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="end_date" data-endpoint="POSTapi-projects" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>users</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="users.0" data-endpoint="POSTapi-projects" data-component="body" required  hidden>
<input type="text" name="users.1" data-endpoint="POSTapi-projects" data-component="body" hidden>
<br>

</p>

</form>


## Enregistrer plusieurs projets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/projects-bulk" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"projects":[{"name":"qui","description":"voluptatem","start_date":"2025-11-22T14:46:46+0000","end_date":"2025-11-22T14:46:46+0000","users":["voluptate"]}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/projects-bulk"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "projects": [
        {
            "name": "qui",
            "description": "voluptatem",
            "start_date": "2025-11-22T14:46:46+0000",
            "end_date": "2025-11-22T14:46:46+0000",
            "users": [
                "voluptate"
            ]
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
    'http://localhost/api/projects-bulk',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'projects' => [
                [
                    'name' => 'qui',
                    'description' => 'voluptatem',
                    'start_date' => '2025-11-22T14:46:46+0000',
                    'end_date' => '2025-11-22T14:46:46+0000',
                    'users' => [
                        'voluptate',
                    ],
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
<div id="execution-results-POSTapi-projects-bulk" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-projects-bulk"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-projects-bulk"></code></pre>
</div>
<div id="execution-error-POSTapi-projects-bulk" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-projects-bulk"></code></pre>
</div>
<form id="form-POSTapi-projects-bulk" data-method="POST" data-path="api/projects-bulk" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-projects-bulk', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/projects-bulk</code></b>
</p>
<p>
<label id="auth-POSTapi-projects-bulk" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-projects-bulk" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>projects</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>projects[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="projects.0.name" data-endpoint="POSTapi-projects-bulk" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>projects[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="projects.0.description" data-endpoint="POSTapi-projects-bulk" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>projects[].start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="projects.0.start_date" data-endpoint="POSTapi-projects-bulk" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>projects[].end_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="projects.0.end_date" data-endpoint="POSTapi-projects-bulk" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>projects[].users</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="projects.0.users.0" data-endpoint="POSTapi-projects-bulk" data-component="body" required  hidden>
<input type="text" name="projects.0.users.1" data-endpoint="POSTapi-projects-bulk" data-component="body" hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un projet

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/projects/deleniti" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/projects/deleniti"
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
    'http://localhost/api/projects/deleniti',
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
<div id="execution-results-GETapi-projects--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-projects--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-projects--id-"></code></pre>
</div>
<div id="execution-error-GETapi-projects--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-projects--id-"></code></pre>
</div>
<form id="form-GETapi-projects--id-" data-method="GET" data-path="api/projects/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-projects--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/projects/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-projects--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-projects--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-projects--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un projet

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/projects/praesentium" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"omnis","description":"eum","start_date":"2025-11-22T14:46:46+0000","end_date":"2025-11-22T14:46:46+0000","users":["voluptatem"]}'

```

```javascript
const url = new URL(
    "http://localhost/api/projects/praesentium"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "omnis",
    "description": "eum",
    "start_date": "2025-11-22T14:46:46+0000",
    "end_date": "2025-11-22T14:46:46+0000",
    "users": [
        "voluptatem"
    ]
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
    'http://localhost/api/projects/praesentium',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'omnis',
            'description' => 'eum',
            'start_date' => '2025-11-22T14:46:46+0000',
            'end_date' => '2025-11-22T14:46:46+0000',
            'users' => [
                'voluptatem',
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
<div id="execution-results-PUTapi-projects--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-projects--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-projects--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-projects--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-projects--id-"></code></pre>
</div>
<form id="form-PUTapi-projects--id-" data-method="PUT" data-path="api/projects/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-projects--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/projects/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-projects--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-projects--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-projects--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-projects--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-projects--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="start_date" data-endpoint="PUTapi-projects--id-" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="end_date" data-endpoint="PUTapi-projects--id-" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>users</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="users.0" data-endpoint="PUTapi-projects--id-" data-component="body" required  hidden>
<input type="text" name="users.1" data-endpoint="PUTapi-projects--id-" data-component="body" hidden>
<br>

</p>

</form>


## Envoyer un projet à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/projects/trash/quos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/projects/trash/quos"
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
    'http://localhost/api/projects/trash/quos',
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
<div id="execution-results-DELETEapi-projects-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-projects-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-projects-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-projects-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-projects-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-projects-trash--id-" data-method="DELETE" data-path="api/projects/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-projects-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/projects/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-projects-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-projects-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-projects-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un projet de la corbeille
NB: Il n&#039;est pas possible de restaurer un projet qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/projects/restore/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/projects/restore/et"
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
    'http://localhost/api/projects/restore/et',
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
<div id="execution-results-POSTapi-projects-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-projects-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-projects-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-projects-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-projects-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-projects-restore--id-" data-method="POST" data-path="api/projects/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-projects-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/projects/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-projects-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-projects-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-projects-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les éléments du règlement intérieur non supprimés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieursall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":9,"nbreItems":20,"filter_value":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieursall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 9,
    "nbreItems": 20,
    "filter_value": "et"
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
    'http://localhost/api/reglements-interieursall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 9,
            'nbreItems' => 20,
            'filter_value' => 'et',
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
<div id="execution-results-POSTapi-reglements-interieursall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieursall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieursall"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieursall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieursall"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieursall" data-method="POST" data-path="api/reglements-interieursall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieursall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieursall</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieursall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieursall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer une ou plusieurs éléments du règlement intérieur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieurs" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"reglements_interieurs":[{"title":"sed","description":"ea","idSchool":12,"idSection":6}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "reglements_interieurs": [
        {
            "title": "sed",
            "description": "ea",
            "idSchool": 12,
            "idSection": 6
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
    'http://localhost/api/reglements-interieurs',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'reglements_interieurs' => [
                [
                    'title' => 'sed',
                    'description' => 'ea',
                    'idSchool' => 12,
                    'idSection' => 6,
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
<div id="execution-results-POSTapi-reglements-interieurs" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieurs"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieurs"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieurs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieurs"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieurs" data-method="POST" data-path="api/reglements-interieurs" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieurs', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieurs</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieurs" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieurs" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>reglements_interieurs</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>reglements_interieurs[].title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.0.title" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.0.description" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="reglements_interieurs.0.idSchool" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="reglements_interieurs.0.idSection" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un élément du règlement intérieur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/reglements-interieurs/maxime" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/maxime"
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
    'http://localhost/api/reglements-interieurs/maxime',
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
<div id="execution-results-GETapi-reglements-interieurs--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-reglements-interieurs--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-reglements-interieurs--id-"></code></pre>
</div>
<div id="execution-error-GETapi-reglements-interieurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-reglements-interieurs--id-"></code></pre>
</div>
<form id="form-GETapi-reglements-interieurs--id-" data-method="GET" data-path="api/reglements-interieurs/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-reglements-interieurs--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/reglements-interieurs/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-reglements-interieurs--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-reglements-interieurs--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-reglements-interieurs--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un projet

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/reglements-interieurs/sunt" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"non","description":"eum","idSchool":9,"idSection":6}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/sunt"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "non",
    "description": "eum",
    "idSchool": 9,
    "idSection": 6
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
    'http://localhost/api/reglements-interieurs/sunt',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'title' => 'non',
            'description' => 'eum',
            'idSchool' => 9,
            'idSection' => 6,
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
<div id="execution-results-PUTapi-reglements-interieurs--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-reglements-interieurs--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-reglements-interieurs--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-reglements-interieurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-reglements-interieurs--id-"></code></pre>
</div>
<form id="form-PUTapi-reglements-interieurs--id-" data-method="PUT" data-path="api/reglements-interieurs/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-reglements-interieurs--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/reglements-interieurs/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-reglements-interieurs--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-reglements-interieurs--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="title" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer un élément du règlement intérieur à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/reglements-interieurs/trash/sit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/trash/sit"
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
    'http://localhost/api/reglements-interieurs/trash/sit',
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
<div id="execution-results-DELETEapi-reglements-interieurs-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-reglements-interieurs-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-reglements-interieurs-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-reglements-interieurs-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-reglements-interieurs-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-reglements-interieurs-trash--id-" data-method="DELETE" data-path="api/reglements-interieurs/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-reglements-interieurs-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/reglements-interieurs/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-reglements-interieurs-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-reglements-interieurs-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-reglements-interieurs-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un élément du règlement intérieur de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieurs/restore/velit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/restore/velit"
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
    'http://localhost/api/reglements-interieurs/restore/velit',
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
<div id="execution-results-POSTapi-reglements-interieurs-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieurs-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieurs-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieurs-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieurs-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieurs-restore--id-" data-method="POST" data-path="api/reglements-interieurs/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieurs-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieurs/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieurs-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieurs-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-reglements-interieurs-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les projets non supprimés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transfertsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":10,"nbreItems":1,"filter_value":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/api/transfertsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 10,
    "nbreItems": 1,
    "filter_value": "et"
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
    'http://localhost/api/transfertsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 10,
            'nbreItems' => 1,
            'filter_value' => 'et',
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
<div id="execution-results-POSTapi-transfertsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transfertsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transfertsall"></code></pre>
</div>
<div id="execution-error-POSTapi-transfertsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transfertsall"></code></pre>
</div>
<form id="form-POSTapi-transfertsall" data-method="POST" data-path="api/transfertsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transfertsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transfertsall</code></b>
</p>
<p>
<label id="auth-POSTapi-transfertsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transfertsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-transfertsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-transfertsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-transfertsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;un certificat de transfert

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/transferts/11" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transferts/11"
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
    'http://localhost/api/transferts/11',
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
<div id="execution-results-GETapi-transferts--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-transferts--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-transferts--id-"></code></pre>
</div>
<div id="execution-error-GETapi-transferts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-transferts--id-"></code></pre>
</div>
<form id="form-GETapi-transferts--id-" data-method="GET" data-path="api/transferts/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-transferts--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/transferts/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-transferts--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-transferts--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-transferts--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les notes de frais non supprimées

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/note-fraisall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"status":"saepe","idUser":14,"idUserApprove":18,"pageItems":20,"nbreItems":7,"filter_value":"deleniti","date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/note-fraisall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "status": "saepe",
    "idUser": 14,
    "idUserApprove": 18,
    "pageItems": 20,
    "nbreItems": 7,
    "filter_value": "deleniti",
    "date": "2025-11-22"
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
    'http://localhost/api/note-fraisall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'status' => 'saepe',
            'idUser' => 14,
            'idUserApprove' => 18,
            'pageItems' => 20,
            'nbreItems' => 7,
            'filter_value' => 'deleniti',
            'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-note-fraisall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-note-fraisall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-note-fraisall"></code></pre>
</div>
<div id="execution-error-POSTapi-note-fraisall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-note-fraisall"></code></pre>
</div>
<form id="form-POSTapi-note-fraisall" data-method="POST" data-path="api/note-fraisall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-note-fraisall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/note-fraisall</code></b>
</p>
<p>
<label id="auth-POSTapi-note-fraisall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-note-fraisall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-note-fraisall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Enregistrer une ou plusieurs notes de frais.

<small class="badge badge-darkred">requires authentication</small>

L'enregistrement génère un fichier PDF ou ZIP contenant les PDFs des notes de frais crées

> Example request:

```bash
curl -X POST \
    "http://localhost/api/note-frais" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"note_frais":[{"idUser":18,"idUserApprove":7,"libelle":"cum","amount":14,"status":"cum","description":"cumque","date":"2025-11-22T14:46:47+0000"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/note-frais"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "note_frais": [
        {
            "idUser": 18,
            "idUserApprove": 7,
            "libelle": "cum",
            "amount": 14,
            "status": "cum",
            "description": "cumque",
            "date": "2025-11-22T14:46:47+0000"
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
    'http://localhost/api/note-frais',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'note_frais' => [
                [
                    'idUser' => 18,
                    'idUserApprove' => 7,
                    'libelle' => 'cum',
                    'amount' => 14,
                    'status' => 'cum',
                    'description' => 'cumque',
                    'date' => '2025-11-22T14:46:47+0000',
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
<div id="execution-results-POSTapi-note-frais" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-note-frais"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-note-frais"></code></pre>
</div>
<div id="execution-error-POSTapi-note-frais" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-note-frais"></code></pre>
</div>
<form id="form-POSTapi-note-frais" data-method="POST" data-path="api/note-frais" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-note-frais', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/note-frais</code></b>
</p>
<p>
<label id="auth-POSTapi-note-frais" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-note-frais" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>note_frais</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>note_frais[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="note_frais.0.idUser" data-endpoint="POSTapi-note-frais" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>note_frais[].idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="note_frais.0.idUserApprove" data-endpoint="POSTapi-note-frais" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>note_frais[].libelle</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="note_frais.0.libelle" data-endpoint="POSTapi-note-frais" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>note_frais[].amount</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="note_frais.0.amount" data-endpoint="POSTapi-note-frais" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>note_frais[].status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="note_frais.0.status" data-endpoint="POSTapi-note-frais" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>note_frais[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="note_frais.0.description" data-endpoint="POSTapi-note-frais" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>note_frais[].date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="note_frais.0.date" data-endpoint="POSTapi-note-frais" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
</details>
</p>

</form>


## Afficher les détails d&#039;une note de frais

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/note-frais/aut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/note-frais/aut"
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
    'http://localhost/api/note-frais/aut',
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
<div id="execution-results-GETapi-note-frais--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-note-frais--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-note-frais--id-"></code></pre>
</div>
<div id="execution-error-GETapi-note-frais--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-note-frais--id-"></code></pre>
</div>
<form id="form-GETapi-note-frais--id-" data-method="GET" data-path="api/note-frais/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-note-frais--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/note-frais/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-note-frais--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-note-frais--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-note-frais--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;une note de frais

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/note-frais/quibusdam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":2,"idUserApprove":2,"libelle":"aliquam","amount":20,"status":"nostrum","description":"totam","date":"2025-11-22T14:46:47+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/note-frais/quibusdam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 2,
    "idUserApprove": 2,
    "libelle": "aliquam",
    "amount": 20,
    "status": "nostrum",
    "description": "totam",
    "date": "2025-11-22T14:46:47+0000"
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
    'http://localhost/api/note-frais/quibusdam',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 2,
            'idUserApprove' => 2,
            'libelle' => 'aliquam',
            'amount' => 20,
            'status' => 'nostrum',
            'description' => 'totam',
            'date' => '2025-11-22T14:46:47+0000',
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
<div id="execution-results-PUTapi-note-frais--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-note-frais--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-note-frais--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-note-frais--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-note-frais--id-"></code></pre>
</div>
<form id="form-PUTapi-note-frais--id-" data-method="PUT" data-path="api/note-frais/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-note-frais--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/note-frais/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-note-frais--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-note-frais--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-note-frais--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>libelle</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="libelle" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="amount" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-note-frais--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Envoyer une note de frais à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/note-frais/trash/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/note-frais/trash/sint"
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
    'http://localhost/api/note-frais/trash/sint',
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
<div id="execution-results-DELETEapi-note-frais-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-note-frais-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-note-frais-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-note-frais-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-note-frais-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-note-frais-trash--id-" data-method="DELETE" data-path="api/note-frais/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-note-frais-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/note-frais/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-note-frais-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-note-frais-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-note-frais-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer une note de frais de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/note-frais/restore/doloribus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/note-frais/restore/doloribus"
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
    'http://localhost/api/note-frais/restore/doloribus',
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
<div id="execution-results-POSTapi-note-frais-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-note-frais-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-note-frais-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-note-frais-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-note-frais-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-note-frais-restore--id-" data-method="POST" data-path="api/note-frais/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-note-frais-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/note-frais/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-note-frais-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-note-frais-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-note-frais-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## RE-Télécharger une ou plusieurs notes de frais

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/note-frais/download" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idsNoteFrais":["voluptas"]}'

```

```javascript
const url = new URL(
    "http://localhost/api/note-frais/download"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idsNoteFrais": [
        "voluptas"
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
    'http://localhost/api/note-frais/download',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idsNoteFrais' => [
                'voluptas',
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
<div id="execution-results-POSTapi-note-frais-download" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-note-frais-download"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-note-frais-download"></code></pre>
</div>
<div id="execution-error-POSTapi-note-frais-download" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-note-frais-download"></code></pre>
</div>
<form id="form-POSTapi-note-frais-download" data-method="POST" data-path="api/note-frais/download" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-note-frais-download', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/note-frais/download</code></b>
</p>
<p>
<label id="auth-POSTapi-note-frais-download" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-note-frais-download" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idsNoteFrais</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="idsNoteFrais.0" data-endpoint="POSTapi-note-frais-download" data-component="body" required  hidden>
<input type="text" name="idsNoteFrais.1" data-endpoint="POSTapi-note-frais-download" data-component="body" hidden>
<br>

</p>

</form>


## Lister les logs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/logsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":8,"pageItems":1,"nbreItems":1,"filter_value":"dolorem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/logsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 8,
    "pageItems": 1,
    "nbreItems": 1,
    "filter_value": "dolorem"
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
    'http://localhost/api/logsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 8,
            'pageItems' => 1,
            'nbreItems' => 1,
            'filter_value' => 'dolorem',
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
<div id="execution-results-POSTapi-logsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-logsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logsall"></code></pre>
</div>
<div id="execution-error-POSTapi-logsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logsall"></code></pre>
</div>
<form id="form-POSTapi-logsall" data-method="POST" data-path="api/logsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-logsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/logsall</code></b>
</p>
<p>
<label id="auth-POSTapi-logsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-logsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-logsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-logsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-logsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-logsall" data-component="body"  hidden>
<br>

</p>

</form>


## api/logs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/logs" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"architecto","idStudent":14,"description":"voluptate"}'

```

```javascript
const url = new URL(
    "http://localhost/api/logs"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "architecto",
    "idStudent": 14,
    "description": "voluptate"
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
    'http://localhost/api/logs',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type' => 'architecto',
            'idStudent' => 14,
            'description' => 'voluptate',
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
<div id="execution-results-POSTapi-logs" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-logs"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logs"></code></pre>
</div>
<div id="execution-error-POSTapi-logs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logs"></code></pre>
</div>
<form id="form-POSTapi-logs" data-method="POST" data-path="api/logs" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-logs', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/logs</code></b>
</p>
<p>
<label id="auth-POSTapi-logs" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-logs" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-logs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-logs" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-logs" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;un log

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/logs/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/logs/12"
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
    'http://localhost/api/logs/12',
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
<div id="execution-results-GETapi-logs--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-logs--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-logs--id-"></code></pre>
</div>
<div id="execution-error-GETapi-logs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-logs--id-"></code></pre>
</div>
<form id="form-GETapi-logs--id-" data-method="GET" data-path="api/logs/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-logs--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/logs/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-logs--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-logs--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-logs--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les pages d&#039;un livre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pages-livresall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":2,"nbreItems":2,"idBook":"sit","filter_value":"omnis","titre":"possimus"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pages-livresall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 2,
    "nbreItems": 2,
    "idBook": "sit",
    "filter_value": "omnis",
    "titre": "possimus"
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
    'http://localhost/api/pages-livresall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 2,
            'nbreItems' => 2,
            'idBook' => 'sit',
            'filter_value' => 'omnis',
            'titre' => 'possimus',
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
<div id="execution-results-POSTapi-pages-livresall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pages-livresall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pages-livresall"></code></pre>
</div>
<div id="execution-error-POSTapi-pages-livresall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pages-livresall"></code></pre>
</div>
<form id="form-POSTapi-pages-livresall" data-method="POST" data-path="api/pages-livresall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pages-livresall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pages-livresall</code></b>
</p>
<p>
<label id="auth-POSTapi-pages-livresall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pages-livresall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-pages-livresall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-pages-livresall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idBook</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idBook" data-endpoint="POSTapi-pages-livresall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-pages-livresall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>titre</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="titre" data-endpoint="POSTapi-pages-livresall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer une ou plusieurs pages d&#039;un livre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pages-livres" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idBook":9,"pages":[{"titre":"esse","sous_titre":"omnis","description":"id"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pages-livres"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idBook": 9,
    "pages": [
        {
            "titre": "esse",
            "sous_titre": "omnis",
            "description": "id"
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
    'http://localhost/api/pages-livres',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idBook' => 9,
            'pages' => [
                [
                    'titre' => 'esse',
                    'sous_titre' => 'omnis',
                    'description' => 'id',
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
<div id="execution-results-POSTapi-pages-livres" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pages-livres"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pages-livres"></code></pre>
</div>
<div id="execution-error-POSTapi-pages-livres" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pages-livres"></code></pre>
</div>
<form id="form-POSTapi-pages-livres" data-method="POST" data-path="api/pages-livres" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pages-livres', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pages-livres</code></b>
</p>
<p>
<label id="auth-POSTapi-pages-livres" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pages-livres" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idBook</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idBook" data-endpoint="POSTapi-pages-livres" data-component="body" required  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>pages</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>pages[].titre</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="pages.0.titre" data-endpoint="POSTapi-pages-livres" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pages[].sous_titre</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pages.0.sous_titre" data-endpoint="POSTapi-pages-livres" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pages[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="pages.0.description" data-endpoint="POSTapi-pages-livres" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;une page de livre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/pages-livres/sunt" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pages-livres/sunt"
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
    'http://localhost/api/pages-livres/sunt',
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
<div id="execution-results-GETapi-pages-livres--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pages-livres--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pages-livres--id-"></code></pre>
</div>
<div id="execution-error-GETapi-pages-livres--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pages-livres--id-"></code></pre>
</div>
<form id="form-GETapi-pages-livres--id-" data-method="GET" data-path="api/pages-livres/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pages-livres--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pages-livres/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-pages-livres--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-pages-livres--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-pages-livres--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;une page de livre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/pages-livres/repellat" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"titre":"dolorum","sous_titre":"accusamus","description":"et","idBook":14}'

```

```javascript
const url = new URL(
    "http://localhost/api/pages-livres/repellat"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "titre": "dolorum",
    "sous_titre": "accusamus",
    "description": "et",
    "idBook": 14
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
    'http://localhost/api/pages-livres/repellat',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'titre' => 'dolorum',
            'sous_titre' => 'accusamus',
            'description' => 'et',
            'idBook' => 14,
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
<div id="execution-results-PUTapi-pages-livres--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-pages-livres--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-pages-livres--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-pages-livres--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-pages-livres--id-"></code></pre>
</div>
<form id="form-PUTapi-pages-livres--id-" data-method="PUT" data-path="api/pages-livres/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-pages-livres--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/pages-livres/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-pages-livres--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-pages-livres--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-pages-livres--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>titre</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="titre" data-endpoint="PUTapi-pages-livres--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>sous_titre</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="sous_titre" data-endpoint="PUTapi-pages-livres--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-pages-livres--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idBook</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idBook" data-endpoint="PUTapi-pages-livres--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer une page de livre à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/pages-livres/trash/ab" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pages-livres/trash/ab"
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
    'http://localhost/api/pages-livres/trash/ab',
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
<div id="execution-results-DELETEapi-pages-livres-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-pages-livres-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-pages-livres-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-pages-livres-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-pages-livres-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-pages-livres-trash--id-" data-method="DELETE" data-path="api/pages-livres/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-pages-livres-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/pages-livres/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-pages-livres-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-pages-livres-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-pages-livres-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer uune page de livre de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pages-livres/restore/vel" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pages-livres/restore/vel"
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
    'http://localhost/api/pages-livres/restore/vel',
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
<div id="execution-results-POSTapi-pages-livres-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pages-livres-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pages-livres-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-pages-livres-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pages-livres-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-pages-livres-restore--id-" data-method="POST" data-path="api/pages-livres/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pages-livres-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pages-livres/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-pages-livres-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pages-livres-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-pages-livres-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Récupère une liste des examens étudiants avec des options de filtrage et de pagination.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/examsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":15,"nbreItems":4,"idAssessment":15,"idAssessmentType":19,"idUser":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/examsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 15,
    "nbreItems": 4,
    "idAssessment": 15,
    "idAssessmentType": 19,
    "idUser": 4
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
    'http://localhost/api/examsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 15,
            'nbreItems' => 4,
            'idAssessment' => 15,
            'idAssessmentType' => 19,
            'idUser' => 4,
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
<div id="execution-results-POSTapi-examsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-examsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-examsall"></code></pre>
</div>
<div id="execution-error-POSTapi-examsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-examsall"></code></pre>
</div>
<form id="form-POSTapi-examsall" data-method="POST" data-path="api/examsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-examsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/examsall</code></b>
</p>
<p>
<label id="auth-POSTapi-examsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-examsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-examsall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouvel examen étudiant après vérification des conditions.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/exams" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAssessment":14,"idAssessmentType":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/exams"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAssessment": 14,
    "idAssessmentType": 8
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
    'http://localhost/api/exams',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAssessment' => 14,
            'idAssessmentType' => 8,
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
<div id="execution-results-POSTapi-exams" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-exams"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-exams"></code></pre>
</div>
<div id="execution-error-POSTapi-exams" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-exams"></code></pre>
</div>
<form id="form-POSTapi-exams" data-method="POST" data-path="api/exams" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-exams', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/exams</code></b>
</p>
<p>
<label id="auth-POSTapi-exams" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-exams" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-exams" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-exams" data-component="body" required  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un examen étudiant spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/exams/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/exams/qui"
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
    'http://localhost/api/exams/qui',
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
<div id="execution-results-GETapi-exams--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-exams--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-exams--id-"></code></pre>
</div>
<div id="execution-error-GETapi-exams--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-exams--id-"></code></pre>
</div>
<form id="form-GETapi-exams--id-" data-method="GET" data-path="api/exams/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-exams--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/exams/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-exams--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-exams--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-exams--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour le statut d&#039;un examen étudiant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/exams/molestiae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/exams/molestiae"
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
    'http://localhost/api/exams/molestiae',
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
<div id="execution-results-PUTapi-exams--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-exams--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-exams--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-exams--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-exams--id-"></code></pre>
</div>
<form id="form-PUTapi-exams--id-" data-method="PUT" data-path="api/exams/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-exams--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/exams/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-exams--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-exams--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-exams--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprime un examen étudiant en le marquant comme supprimé.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/exams/trash/quis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/exams/trash/quis"
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
    'http://localhost/api/exams/trash/quis',
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
<div id="execution-results-DELETEapi-exams-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-exams-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-exams-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-exams-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-exams-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-exams-trash--id-" data-method="DELETE" data-path="api/exams/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-exams-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/exams/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-exams-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-exams-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-exams-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaure un examen étudiant supprimé.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/exams/restore/voluptas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/exams/restore/voluptas"
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
    'http://localhost/api/exams/restore/voluptas',
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
<div id="execution-results-POSTapi-exams-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-exams-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-exams-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-exams-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-exams-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-exams-restore--id-" data-method="POST" data-path="api/exams/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-exams-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/exams/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-exams-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-exams-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-exams-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les questions d&#039;un examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/questionnairesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":4,"idSection":14,"idAssessment":15,"idAssessmentType":16,"pageItems":11,"nbreItems":2,"filter_value":"iusto","order":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/questionnairesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 4,
    "idSection": 14,
    "idAssessment": 15,
    "idAssessmentType": 16,
    "pageItems": 11,
    "nbreItems": 2,
    "filter_value": "iusto",
    "order": false
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
    'http://localhost/api/questionnairesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 4,
            'idSection' => 14,
            'idAssessment' => 15,
            'idAssessmentType' => 16,
            'pageItems' => 11,
            'nbreItems' => 2,
            'filter_value' => 'iusto',
            'order' => false,
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
<div id="execution-results-POSTapi-questionnairesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-questionnairesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-questionnairesall"></code></pre>
</div>
<div id="execution-error-POSTapi-questionnairesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-questionnairesall"></code></pre>
</div>
<form id="form-POSTapi-questionnairesall" data-method="POST" data-path="api/questionnairesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-questionnairesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/questionnairesall</code></b>
</p>
<p>
<label id="auth-POSTapi-questionnairesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-questionnairesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>order</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-questionnairesall" hidden><input type="radio" name="order" value="true" data-endpoint="POSTapi-questionnairesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-questionnairesall" hidden><input type="radio" name="order" value="false" data-endpoint="POSTapi-questionnairesall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer une question d&#039;examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/questionnaires" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAssessment":1,"idAssessmentType":16,"intitule":"temporibus","reponse":"sapiente","notemax":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/questionnaires"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAssessment": 1,
    "idAssessmentType": 16,
    "intitule": "temporibus",
    "reponse": "sapiente",
    "notemax": 4
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
    'http://localhost/api/questionnaires',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAssessment' => 1,
            'idAssessmentType' => 16,
            'intitule' => 'temporibus',
            'reponse' => 'sapiente',
            'notemax' => 4,
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
<div id="execution-results-POSTapi-questionnaires" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-questionnaires"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-questionnaires"></code></pre>
</div>
<div id="execution-error-POSTapi-questionnaires" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-questionnaires"></code></pre>
</div>
<form id="form-POSTapi-questionnaires" data-method="POST" data-path="api/questionnaires" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-questionnaires', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/questionnaires</code></b>
</p>
<p>
<label id="auth-POSTapi-questionnaires" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-questionnaires" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-questionnaires" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-questionnaires" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>intitule</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="intitule" data-endpoint="POSTapi-questionnaires" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reponse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reponse" data-endpoint="POSTapi-questionnaires" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>notemax</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="notemax" data-endpoint="POSTapi-questionnaires" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une question

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/questionnaires/nihil" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/questionnaires/nihil"
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
    'http://localhost/api/questionnaires/nihil',
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
<div id="execution-results-GETapi-questionnaires--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-questionnaires--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-questionnaires--id-"></code></pre>
</div>
<div id="execution-error-GETapi-questionnaires--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-questionnaires--id-"></code></pre>
</div>
<form id="form-GETapi-questionnaires--id-" data-method="GET" data-path="api/questionnaires/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-questionnaires--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/questionnaires/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-questionnaires--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-questionnaires--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-questionnaires--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;une question d&#039;examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/questionnaires/alias" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAssessment":3,"idAssessmentType":5,"intitule":"esse","reponse":"amet","notemax":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/questionnaires/alias"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAssessment": 3,
    "idAssessmentType": 5,
    "intitule": "esse",
    "reponse": "amet",
    "notemax": 13
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
    'http://localhost/api/questionnaires/alias',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAssessment' => 3,
            'idAssessmentType' => 5,
            'intitule' => 'esse',
            'reponse' => 'amet',
            'notemax' => 13,
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
<div id="execution-results-PUTapi-questionnaires--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-questionnaires--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-questionnaires--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-questionnaires--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-questionnaires--id-"></code></pre>
</div>
<form id="form-PUTapi-questionnaires--id-" data-method="PUT" data-path="api/questionnaires/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-questionnaires--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/questionnaires/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-questionnaires--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-questionnaires--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-questionnaires--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="PUTapi-questionnaires--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="PUTapi-questionnaires--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>intitule</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="intitule" data-endpoint="PUTapi-questionnaires--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reponse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reponse" data-endpoint="PUTapi-questionnaires--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>notemax</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="notemax" data-endpoint="PUTapi-questionnaires--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer une question à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/questionnaires/trash/beatae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/questionnaires/trash/beatae"
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
    'http://localhost/api/questionnaires/trash/beatae',
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
<div id="execution-results-DELETEapi-questionnaires-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-questionnaires-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-questionnaires-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-questionnaires-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-questionnaires-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-questionnaires-trash--id-" data-method="DELETE" data-path="api/questionnaires/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-questionnaires-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/questionnaires/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-questionnaires-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-questionnaires-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-questionnaires-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer une question de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/questionnaires/restore/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/questionnaires/restore/et"
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
    'http://localhost/api/questionnaires/restore/et',
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
<div id="execution-results-POSTapi-questionnaires-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-questionnaires-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-questionnaires-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-questionnaires-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-questionnaires-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-questionnaires-restore--id-" data-method="POST" data-path="api/questionnaires/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-questionnaires-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/questionnaires/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-questionnaires-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-questionnaires-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-questionnaires-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les propositions de questions d&#039;un examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/propositions-questionnairesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":8,"nbreItems":5,"filter_value":"ut","idQuestion":14}'

```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnairesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 8,
    "nbreItems": 5,
    "filter_value": "ut",
    "idQuestion": 14
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
    'http://localhost/api/propositions-questionnairesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 8,
            'nbreItems' => 5,
            'filter_value' => 'ut',
            'idQuestion' => 14,
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
<div id="execution-results-POSTapi-propositions-questionnairesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-propositions-questionnairesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-propositions-questionnairesall"></code></pre>
</div>
<div id="execution-error-POSTapi-propositions-questionnairesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-propositions-questionnairesall"></code></pre>
</div>
<form id="form-POSTapi-propositions-questionnairesall" data-method="POST" data-path="api/propositions-questionnairesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-propositions-questionnairesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/propositions-questionnairesall</code></b>
</p>
<p>
<label id="auth-POSTapi-propositions-questionnairesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-propositions-questionnairesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-propositions-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-propositions-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-propositions-questionnairesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idQuestion</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idQuestion" data-endpoint="POSTapi-propositions-questionnairesall" data-component="body" required  hidden>
<br>

</p>

</form>


## Enregistrer une proposition de question

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/propositions-questionnaires" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idQuestion":6,"propositions":[{"intitule":"voluptates","is_correct":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnaires"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idQuestion": 6,
    "propositions": [
        {
            "intitule": "voluptates",
            "is_correct": false
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
    'http://localhost/api/propositions-questionnaires',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idQuestion' => 6,
            'propositions' => [
                [
                    'intitule' => 'voluptates',
                    'is_correct' => false,
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
<div id="execution-results-POSTapi-propositions-questionnaires" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-propositions-questionnaires"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-propositions-questionnaires"></code></pre>
</div>
<div id="execution-error-POSTapi-propositions-questionnaires" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-propositions-questionnaires"></code></pre>
</div>
<form id="form-POSTapi-propositions-questionnaires" data-method="POST" data-path="api/propositions-questionnaires" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-propositions-questionnaires', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/propositions-questionnaires</code></b>
</p>
<p>
<label id="auth-POSTapi-propositions-questionnaires" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-propositions-questionnaires" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idQuestion</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idQuestion" data-endpoint="POSTapi-propositions-questionnaires" data-component="body" required  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>propositions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>propositions[].intitule</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="propositions.0.intitule" data-endpoint="POSTapi-propositions-questionnaires" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>propositions[].is_correct</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-propositions-questionnaires" hidden><input type="radio" name="propositions.0.is_correct" value="true" data-endpoint="POSTapi-propositions-questionnaires" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-propositions-questionnaires" hidden><input type="radio" name="propositions.0.is_correct" value="false" data-endpoint="POSTapi-propositions-questionnaires" data-component="body" required ><code>false</code></label>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;une proposition de question

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/propositions-questionnaires/aut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnaires/aut"
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
    'http://localhost/api/propositions-questionnaires/aut',
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
<div id="execution-results-GETapi-propositions-questionnaires--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-propositions-questionnaires--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-propositions-questionnaires--id-"></code></pre>
</div>
<div id="execution-error-GETapi-propositions-questionnaires--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-propositions-questionnaires--id-"></code></pre>
</div>
<form id="form-GETapi-propositions-questionnaires--id-" data-method="GET" data-path="api/propositions-questionnaires/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-propositions-questionnaires--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/propositions-questionnaires/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-propositions-questionnaires--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-propositions-questionnaires--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-propositions-questionnaires--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;une proposition de question d&#039;examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/propositions-questionnaires/rerum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"intitule":"quod","is_correct":false,"idQuestionnaire":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnaires/rerum"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "intitule": "quod",
    "is_correct": false,
    "idQuestionnaire": 2
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
    'http://localhost/api/propositions-questionnaires/rerum',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'intitule' => 'quod',
            'is_correct' => false,
            'idQuestionnaire' => 2,
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
<div id="execution-results-PUTapi-propositions-questionnaires--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-propositions-questionnaires--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-propositions-questionnaires--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-propositions-questionnaires--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-propositions-questionnaires--id-"></code></pre>
</div>
<form id="form-PUTapi-propositions-questionnaires--id-" data-method="PUT" data-path="api/propositions-questionnaires/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-propositions-questionnaires--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/propositions-questionnaires/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-propositions-questionnaires--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>intitule</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="intitule" data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>is_correct</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-propositions-questionnaires--id-" hidden><input type="radio" name="is_correct" value="true" data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-propositions-questionnaires--id-" hidden><input type="radio" name="is_correct" value="false" data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idQuestionnaire</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idQuestionnaire" data-endpoint="PUTapi-propositions-questionnaires--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer une proposition de question à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/propositions-questionnaires/trash/fugit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnaires/trash/fugit"
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
    'http://localhost/api/propositions-questionnaires/trash/fugit',
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
<div id="execution-results-DELETEapi-propositions-questionnaires-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-propositions-questionnaires-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-propositions-questionnaires-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-propositions-questionnaires-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-propositions-questionnaires-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-propositions-questionnaires-trash--id-" data-method="DELETE" data-path="api/propositions-questionnaires/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-propositions-questionnaires-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/propositions-questionnaires/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-propositions-questionnaires-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-propositions-questionnaires-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-propositions-questionnaires-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer une proposition de question de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/propositions-questionnaires/restore/natus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/propositions-questionnaires/restore/natus"
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
    'http://localhost/api/propositions-questionnaires/restore/natus',
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
<div id="execution-results-POSTapi-propositions-questionnaires-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-propositions-questionnaires-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-propositions-questionnaires-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-propositions-questionnaires-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-propositions-questionnaires-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-propositions-questionnaires-restore--id-" data-method="POST" data-path="api/propositions-questionnaires/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-propositions-questionnaires-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/propositions-questionnaires/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-propositions-questionnaires-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-propositions-questionnaires-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-propositions-questionnaires-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Récupérer la liste des examens avec la possibilité d&#039;appliquer des filtres

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/responses/all" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":20,"nbreItems":6,"filter_value":"nostrum","idAssessmentType":2,"idAssessment":3,"idUser":15,"idQuestion":12}'

```

```javascript
const url = new URL(
    "http://localhost/api/responses/all"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 20,
    "nbreItems": 6,
    "filter_value": "nostrum",
    "idAssessmentType": 2,
    "idAssessment": 3,
    "idUser": 15,
    "idQuestion": 12
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
    'http://localhost/api/responses/all',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 20,
            'nbreItems' => 6,
            'filter_value' => 'nostrum',
            'idAssessmentType' => 2,
            'idAssessment' => 3,
            'idUser' => 15,
            'idQuestion' => 12,
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
<div id="execution-results-POSTapi-responses-all" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-responses-all"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-responses-all"></code></pre>
</div>
<div id="execution-error-POSTapi-responses-all" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-responses-all"></code></pre>
</div>
<form id="form-POSTapi-responses-all" data-method="POST" data-path="api/responses/all" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-responses-all', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/responses/all</code></b>
</p>
<p>
<label id="auth-POSTapi-responses-all" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-responses-all" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idQuestion</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idQuestion" data-endpoint="POSTapi-responses-all" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistre les réponses d&#039;un étudiant pour un examen.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/responses" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAssessment":1,"idAssessmentType":14,"responses":[{"idQuestion":17,"response":"distinctio"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/responses"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAssessment": 1,
    "idAssessmentType": 14,
    "responses": [
        {
            "idQuestion": 17,
            "response": "distinctio"
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
    'http://localhost/api/responses',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAssessment' => 1,
            'idAssessmentType' => 14,
            'responses' => [
                [
                    'idQuestion' => 17,
                    'response' => 'distinctio',
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
<div id="execution-results-POSTapi-responses" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-responses"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-responses"></code></pre>
</div>
<div id="execution-error-POSTapi-responses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-responses"></code></pre>
</div>
<form id="form-POSTapi-responses" data-method="POST" data-path="api/responses" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-responses', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/responses</code></b>
</p>
<p>
<label id="auth-POSTapi-responses" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-responses" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-responses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-responses" data-component="body" required  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>responses</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>responses[].idQuestion</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="responses.0.idQuestion" data-endpoint="POSTapi-responses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>responses[].response</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="responses.0.response" data-endpoint="POSTapi-responses" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## api/responses/{id}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/responses/tempora" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"response":"fugit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/responses/tempora"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "response": "fugit"
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
    'http://localhost/api/responses/tempora',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'response' => 'fugit',
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
<div id="execution-results-PUTapi-responses--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-responses--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-responses--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-responses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-responses--id-"></code></pre>
</div>
<form id="form-PUTapi-responses--id-" data-method="PUT" data-path="api/responses/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-responses--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/responses/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-responses--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-responses--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-responses--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>response</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="response" data-endpoint="PUTapi-responses--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprime une réponse d&#039;étudiant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/responses/trash/quasi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/responses/trash/quasi"
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
    'http://localhost/api/responses/trash/quasi',
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
<div id="execution-results-DELETEapi-responses-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-responses-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-responses-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-responses-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-responses-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-responses-trash--id-" data-method="DELETE" data-path="api/responses/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-responses-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/responses/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-responses-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-responses-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-responses-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaure une réponse d&#039;étudiant supprimée.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/responses/restore/aliquam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/responses/restore/aliquam"
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
    'http://localhost/api/responses/restore/aliquam',
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
<div id="execution-results-POSTapi-responses-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-responses-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-responses-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-responses-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-responses-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-responses-restore--id-" data-method="POST" data-path="api/responses/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-responses-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/responses/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-responses-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-responses-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-responses-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Récupérer toutes les réponses d&#039;un enfant à un examen et pour une séquence donnés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mark-exam-online/get-student-responses" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":4,"idAssessment":6,"idAssessmentType":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/mark-exam-online/get-student-responses"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 4,
    "idAssessment": 6,
    "idAssessmentType": 13
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
    'http://localhost/api/mark-exam-online/get-student-responses',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 4,
            'idAssessment' => 6,
            'idAssessmentType' => 13,
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
<div id="execution-results-POSTapi-mark-exam-online-get-student-responses" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mark-exam-online-get-student-responses"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mark-exam-online-get-student-responses"></code></pre>
</div>
<div id="execution-error-POSTapi-mark-exam-online-get-student-responses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mark-exam-online-get-student-responses"></code></pre>
</div>
<form id="form-POSTapi-mark-exam-online-get-student-responses" data-method="POST" data-path="api/mark-exam-online/get-student-responses" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mark-exam-online-get-student-responses', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mark-exam-online/get-student-responses</code></b>
</p>
<p>
<label id="auth-POSTapi-mark-exam-online-get-student-responses" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mark-exam-online-get-student-responses" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-mark-exam-online-get-student-responses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-mark-exam-online-get-student-responses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-mark-exam-online-get-student-responses" data-component="body" required  hidden>
<br>

</p>

</form>


## Corriger l&#039;épreuve d&#039;un étudiant sur un examen en ligne

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mark-exam-online/set-student-notes" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":12,"idAssessment":7,"idAssessmentType":3,"notes":[{"idQuestionnaire":5,"idResponseUser":17,"note":173.028218259,"status":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/mark-exam-online/set-student-notes"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 12,
    "idAssessment": 7,
    "idAssessmentType": 3,
    "notes": [
        {
            "idQuestionnaire": 5,
            "idResponseUser": 17,
            "note": 173.028218259,
            "status": false
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
    'http://localhost/api/mark-exam-online/set-student-notes',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 12,
            'idAssessment' => 7,
            'idAssessmentType' => 3,
            'notes' => [
                [
                    'idQuestionnaire' => 5,
                    'idResponseUser' => 17,
                    'note' => 173.028218259,
                    'status' => false,
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
<div id="execution-results-POSTapi-mark-exam-online-set-student-notes" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mark-exam-online-set-student-notes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mark-exam-online-set-student-notes"></code></pre>
</div>
<div id="execution-error-POSTapi-mark-exam-online-set-student-notes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mark-exam-online-set-student-notes"></code></pre>
</div>
<form id="form-POSTapi-mark-exam-online-set-student-notes" data-method="POST" data-path="api/mark-exam-online/set-student-notes" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mark-exam-online-set-student-notes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mark-exam-online/set-student-notes</code></b>
</p>
<p>
<label id="auth-POSTapi-mark-exam-online-set-student-notes" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>notes</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>notes[].idQuestionnaire</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="notes.0.idQuestionnaire" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>notes[].idResponseUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="notes.0.idResponseUser" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>notes[].note</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="notes.0.note" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>notes[].status</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-mark-exam-online-set-student-notes" hidden><input type="radio" name="notes.0.status" value="true" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-mark-exam-online-set-student-notes" hidden><input type="radio" name="notes.0.status" value="false" data-endpoint="POSTapi-mark-exam-online-set-student-notes" data-component="body" ><code>false</code></label>
<br>

</p>
</details>
</p>

</form>


## Récupérer la liste des clients

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/clientsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":4,"nbreItems":14,"filter_value":"nesciunt","type":"quod"}'

```

```javascript
const url = new URL(
    "http://localhost/api/clientsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 4,
    "nbreItems": 14,
    "filter_value": "nesciunt",
    "type": "quod"
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
    'http://localhost/api/clientsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 4,
            'nbreItems' => 14,
            'filter_value' => 'nesciunt',
            'type' => 'quod',
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
<div id="execution-results-POSTapi-clientsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-clientsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clientsall"></code></pre>
</div>
<div id="execution-error-POSTapi-clientsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clientsall"></code></pre>
</div>
<form id="form-POSTapi-clientsall" data-method="POST" data-path="api/clientsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-clientsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/clientsall</code></b>
</p>
<p>
<label id="auth-POSTapi-clientsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-clientsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-clientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-clientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-clientsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-clientsall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer un nouveau client

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/clients" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"clients":[{"name":"ut","adresse":"expedita","image":"sed","website":"sunt","niu":"mollitia","type":"personnel","rc":"iure","phone":"occaecati","mobile":"odio","email":"ttorp@example.com","country":"addie95@example.org","city":"maurice78@example.net","cni":"kosinski@example.org"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/clients"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "clients": [
        {
            "name": "ut",
            "adresse": "expedita",
            "image": "sed",
            "website": "sunt",
            "niu": "mollitia",
            "type": "personnel",
            "rc": "iure",
            "phone": "occaecati",
            "mobile": "odio",
            "email": "ttorp@example.com",
            "country": "addie95@example.org",
            "city": "maurice78@example.net",
            "cni": "kosinski@example.org"
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
    'http://localhost/api/clients',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'clients' => [
                [
                    'name' => 'ut',
                    'adresse' => 'expedita',
                    'image' => 'sed',
                    'website' => 'sunt',
                    'niu' => 'mollitia',
                    'type' => 'personnel',
                    'rc' => 'iure',
                    'phone' => 'occaecati',
                    'mobile' => 'odio',
                    'email' => 'ttorp@example.com',
                    'country' => 'addie95@example.org',
                    'city' => 'maurice78@example.net',
                    'cni' => 'kosinski@example.org',
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
<div id="execution-results-POSTapi-clients" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-clients"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clients"></code></pre>
</div>
<div id="execution-error-POSTapi-clients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clients"></code></pre>
</div>
<form id="form-POSTapi-clients" data-method="POST" data-path="api/clients" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-clients', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/clients</code></b>
</p>
<p>
<label id="auth-POSTapi-clients" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-clients" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>clients</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>clients[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="clients.0.name" data-endpoint="POSTapi-clients" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>clients[].adresse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.adresse" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>clients[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.image" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>clients[].website</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.website" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>clients[].niu</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.niu" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>clients[].type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="clients.0.type" data-endpoint="POSTapi-clients" data-component="body" required  hidden>
<br>
The value must be one of <code>entreprise</code> or <code>personnel</code>.
</p>
<p>
<b><code>clients[].rc</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.rc" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>clients[].phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="clients.0.phone" data-endpoint="POSTapi-clients" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>clients[].mobile</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="clients.0.mobile" data-endpoint="POSTapi-clients" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>clients[].email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="clients.0.email" data-endpoint="POSTapi-clients" data-component="body" required  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>clients[].country</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.country" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>clients[].city</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.city" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>clients[].cni</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="clients.0.cni" data-endpoint="POSTapi-clients" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
</details>
</p>

</form>


## Afficher les informations d&#039;un client

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/clients/exercitationem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/clients/exercitationem"
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
    'http://localhost/api/clients/exercitationem',
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
<div id="execution-results-GETapi-clients--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-clients--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clients--id-"></code></pre>
</div>
<div id="execution-error-GETapi-clients--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clients--id-"></code></pre>
</div>
<form id="form-GETapi-clients--id-" data-method="GET" data-path="api/clients/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-clients--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/clients/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-clients--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-clients--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-clients--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour les infos d&#039;un client

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/clients/placeat" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"in","adresse":"omnis","image":"sint","website":"libero","niu":"consequatur","type":"entreprise","rc":"in","phone":"iste","mobile":"fuga","email":"qratke@example.net","country":"eva.lowe@example.net","city":"julien.gutkowski@example.com","cni":"nasir.moore@example.net"}'

```

```javascript
const url = new URL(
    "http://localhost/api/clients/placeat"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "in",
    "adresse": "omnis",
    "image": "sint",
    "website": "libero",
    "niu": "consequatur",
    "type": "entreprise",
    "rc": "in",
    "phone": "iste",
    "mobile": "fuga",
    "email": "qratke@example.net",
    "country": "eva.lowe@example.net",
    "city": "julien.gutkowski@example.com",
    "cni": "nasir.moore@example.net"
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
    'http://localhost/api/clients/placeat',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'in',
            'adresse' => 'omnis',
            'image' => 'sint',
            'website' => 'libero',
            'niu' => 'consequatur',
            'type' => 'entreprise',
            'rc' => 'in',
            'phone' => 'iste',
            'mobile' => 'fuga',
            'email' => 'qratke@example.net',
            'country' => 'eva.lowe@example.net',
            'city' => 'julien.gutkowski@example.com',
            'cni' => 'nasir.moore@example.net',
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
<div id="execution-results-PUTapi-clients--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-clients--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-clients--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-clients--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-clients--id-"></code></pre>
</div>
<form id="form-PUTapi-clients--id-" data-method="PUT" data-path="api/clients/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-clients--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/clients/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-clients--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-clients--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-clients--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="adresse" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>website</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="website" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>niu</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="niu" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>
The value must be one of <code>entreprise</code> or <code>personnel</code>.
</p>
<p>
<b><code>rc</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="rc" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>mobile</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mobile" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>country</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="country" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>city</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="city" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>cni</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="cni" data-endpoint="PUTapi-clients--id-" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>

</form>


## Envoyer un client à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/clients/trash/aut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/clients/trash/aut"
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
    'http://localhost/api/clients/trash/aut',
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
<div id="execution-results-DELETEapi-clients-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-clients-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-clients-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-clients-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-clients-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-clients-trash--id-" data-method="DELETE" data-path="api/clients/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-clients-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/clients/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-clients-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-clients-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-clients-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un client de la corbeille-B: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/clients/restore/tempore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/clients/restore/tempore"
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
    'http://localhost/api/clients/restore/tempore',
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
<div id="execution-results-POSTapi-clients-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-clients-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clients-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-clients-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clients-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-clients-restore--id-" data-method="POST" data-path="api/clients/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-clients-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/clients/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-clients-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-clients-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-clients-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Récupérer la liste des encaissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashinsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":2,"nbreItems":5,"filter_value":"perferendis","idClient":1,"irpp":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashinsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 2,
    "nbreItems": 5,
    "filter_value": "perferendis",
    "idClient": 1,
    "irpp": false
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
    'http://localhost/api/cashinsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 2,
            'nbreItems' => 5,
            'filter_value' => 'perferendis',
            'idClient' => 1,
            'irpp' => false,
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
<div id="execution-results-POSTapi-cashinsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashinsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashinsall"></code></pre>
</div>
<div id="execution-error-POSTapi-cashinsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashinsall"></code></pre>
</div>
<form id="form-POSTapi-cashinsall" data-method="POST" data-path="api/cashinsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashinsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashinsall</code></b>
</p>
<p>
<label id="auth-POSTapi-cashinsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashinsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-cashinsall" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-cashinsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-cashinsall" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-cashinsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer un nouveau encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":2,"amount_to_receive":80883379,"amount_received":6151062.178,"reason":"aliquam","payment_method":"placeat","irpp":false,"payment_date":"2025-11-22","receipt_number":"sapiente","operator":"blanditiis","idTypeOfRecipe":6}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 2,
    "amount_to_receive": 80883379,
    "amount_received": 6151062.178,
    "reason": "aliquam",
    "payment_method": "placeat",
    "irpp": false,
    "payment_date": "2025-11-22",
    "receipt_number": "sapiente",
    "operator": "blanditiis",
    "idTypeOfRecipe": 6
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
    'http://localhost/api/cashins',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 2,
            'amount_to_receive' => 80883379.0,
            'amount_received' => 6151062.178,
            'reason' => 'aliquam',
            'payment_method' => 'placeat',
            'irpp' => false,
            'payment_date' => '2025-11-22',
            'receipt_number' => 'sapiente',
            'operator' => 'blanditiis',
            'idTypeOfRecipe' => 6,
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
<div id="execution-results-POSTapi-cashins" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins"></code></pre>
</div>
<form id="form-POSTapi-cashins" data-method="POST" data-path="api/cashins" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_method" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-cashins" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-cashins" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-cashins" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-cashins" data-component="body" required ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les informations d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/cashins/nihil" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/nihil"
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
    'http://localhost/api/cashins/nihil',
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
<div id="execution-results-GETapi-cashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cashins--id-"></code></pre>
</div>
<div id="execution-error-GETapi-cashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cashins--id-"></code></pre>
</div>
<form id="form-GETapi-cashins--id-" data-method="GET" data-path="api/cashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cashins/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-cashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-cashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-cashins--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour les infos d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/cashins/vitae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":16,"amount_to_receive":11,"amount_received":137730.929432,"reason":"quis","payment_method":"molestiae","irpp":false,"payment_date":"2025-11-22T14:46:48+0000","receipt_number":"sed","operator":"delectus","idTypeOfRecipe":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins/vitae"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 16,
    "amount_to_receive": 11,
    "amount_received": 137730.929432,
    "reason": "quis",
    "payment_method": "molestiae",
    "irpp": false,
    "payment_date": "2025-11-22T14:46:48+0000",
    "receipt_number": "sed",
    "operator": "delectus",
    "idTypeOfRecipe": 8
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
    'http://localhost/api/cashins/vitae',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 16,
            'amount_to_receive' => 11.0,
            'amount_received' => 137730.929432,
            'reason' => 'quis',
            'payment_method' => 'molestiae',
            'irpp' => false,
            'payment_date' => '2025-11-22T14:46:48+0000',
            'receipt_number' => 'sed',
            'operator' => 'delectus',
            'idTypeOfRecipe' => 8,
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
<div id="execution-results-PUTapi-cashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-cashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cashins--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-cashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cashins--id-"></code></pre>
</div>
<form id="form-PUTapi-cashins--id-" data-method="PUT" data-path="api/cashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-cashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/cashins/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-cashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-cashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-cashins--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClient" data-endpoint="PUTapi-cashins--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_method" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-cashins--id-" hidden><input type="radio" name="irpp" value="true" data-endpoint="PUTapi-cashins--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-cashins--id-" hidden><input type="radio" name="irpp" value="false" data-endpoint="PUTapi-cashins--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer un encaissement à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/cashins/trash/modi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/trash/modi"
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
    'http://localhost/api/cashins/trash/modi',
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
<div id="execution-results-DELETEapi-cashins-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-cashins-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cashins-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-cashins-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cashins-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-cashins-trash--id-" data-method="DELETE" data-path="api/cashins/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cashins-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/cashins/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-cashins-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-cashins-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-cashins-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un encaissement de la corbeille
Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins/restore/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/restore/sed"
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
    'http://localhost/api/cashins/restore/sed',
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
<div id="execution-results-POSTapi-cashins-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-cashins-restore--id-" data-method="POST" data-path="api/cashins/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-cashins-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Envoyer un message à un ou plusieurs utisateurs connaissant leurs IDs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/sms" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUsers":[8,3],"message":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sms"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUsers": [
        8,
        3
    ],
    "message": "omnis"
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
    'http://localhost/api/sms',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUsers' => [
                8,
                3,
            ],
            'message' => 'omnis',
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
<div id="execution-results-POSTapi-sms" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-sms"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sms"></code></pre>
</div>
<div id="execution-error-POSTapi-sms" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sms"></code></pre>
</div>
<form id="form-POSTapi-sms" data-method="POST" data-path="api/sms" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-sms', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/sms</code></b>
</p>
<p>
<label id="auth-POSTapi-sms" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-sms" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUsers</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="idUsers.0" data-endpoint="POSTapi-sms" data-component="body"  hidden>
<input type="number" name="idUsers.1" data-endpoint="POSTapi-sms" data-component="body" hidden>
<br>

</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="message" data-endpoint="POSTapi-sms" data-component="body" required  hidden>
<br>

</p>

</form>


## Envoyer un message à un ou plusieurs utisateurs numero de telephone

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/sms/to" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"numbers":["repudiandae","itaque"],"message":"ea"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sms/to"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "numbers": [
        "repudiandae",
        "itaque"
    ],
    "message": "ea"
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
    'http://localhost/api/sms/to',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'numbers' => [
                'repudiandae',
                'itaque',
            ],
            'message' => 'ea',
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
<div id="execution-results-POSTapi-sms-to" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-sms-to"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sms-to"></code></pre>
</div>
<div id="execution-error-POSTapi-sms-to" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sms-to"></code></pre>
</div>
<form id="form-POSTapi-sms-to" data-method="POST" data-path="api/sms/to" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-sms-to', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/sms/to</code></b>
</p>
<p>
<label id="auth-POSTapi-sms-to" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-sms-to" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>numbers</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="numbers.0" data-endpoint="POSTapi-sms-to" data-component="body"  hidden>
<input type="text" name="numbers.1" data-endpoint="POSTapi-sms-to" data-component="body" hidden>
<br>

</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="message" data-endpoint="POSTapi-sms-to" data-component="body" required  hidden>
<br>

</p>

</form>


## Lister les SMS envoyés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/sms/all" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"status":"success","idSchool":18,"idSection":8,"pageItems":5,"nbreItems":8,"filter_value":"et","date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sms/all"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "status": "success",
    "idSchool": 18,
    "idSection": 8,
    "pageItems": 5,
    "nbreItems": 8,
    "filter_value": "et",
    "date": "2025-11-22"
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
    'http://localhost/api/sms/all',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'status' => 'success',
            'idSchool' => 18,
            'idSection' => 8,
            'pageItems' => 5,
            'nbreItems' => 8,
            'filter_value' => 'et',
            'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-sms-all" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-sms-all"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sms-all"></code></pre>
</div>
<div id="execution-error-POSTapi-sms-all" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sms-all"></code></pre>
</div>
<form id="form-POSTapi-sms-all" data-method="POST" data-path="api/sms/all" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-sms-all', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/sms/all</code></b>
</p>
<p>
<label id="auth-POSTapi-sms-all" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-sms-all" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>
The value must be one of <code>success</code> or <code>failed</code>.
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-sms-all" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Récupérer le solde SMS du compte

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/sms/balance" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/sms/balance"
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
    'http://localhost/api/sms/balance',
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
<div id="execution-results-GETapi-sms-balance" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-sms-balance"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-sms-balance"></code></pre>
</div>
<div id="execution-error-GETapi-sms-balance" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-sms-balance"></code></pre>
</div>
<form id="form-GETapi-sms-balance" data-method="GET" data-path="api/sms/balance" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-sms-balance', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/sms/balance</code></b>
</p>
<p>
<label id="auth-GETapi-sms-balance" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-sms-balance" data-component="header"></label>
</p>
</form>


## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/permissions-usersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":4,"nbreItems":11,"filterValue":"voluptatem","dateDepart":"2025-11-22T14:46:49+0000","dateRetour":"2025-11-22T14:46:49+0000","duration":9,"status":"quibusdam","trashed":"onlyTrashed"}'

```

```javascript
const url = new URL(
    "http://localhost/api/permissions-usersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 4,
    "nbreItems": 11,
    "filterValue": "voluptatem",
    "dateDepart": "2025-11-22T14:46:49+0000",
    "dateRetour": "2025-11-22T14:46:49+0000",
    "duration": 9,
    "status": "quibusdam",
    "trashed": "onlyTrashed"
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
    'http://localhost/api/permissions-usersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 4,
            'nbreItems' => 11,
            'filterValue' => 'voluptatem',
            'dateDepart' => '2025-11-22T14:46:49+0000',
            'dateRetour' => '2025-11-22T14:46:49+0000',
            'duration' => 9,
            'status' => 'quibusdam',
            'trashed' => 'onlyTrashed',
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
<div id="execution-results-POSTapi-permissions-usersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-permissions-usersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-permissions-usersall"></code></pre>
</div>
<div id="execution-error-POSTapi-permissions-usersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-permissions-usersall"></code></pre>
</div>
<form id="form-POSTapi-permissions-usersall" data-method="POST" data-path="api/permissions-usersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-permissions-usersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/permissions-usersall</code></b>
</p>
<p>
<label id="auth-POSTapi-permissions-usersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-permissions-usersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filterValue</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filterValue" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>dateDepart</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="dateDepart" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>dateRetour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="dateRetour" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="duration" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="trashed" data-endpoint="POSTapi-permissions-usersall" data-component="body"  hidden>
<br>
The value must be one of <code>withTrashed</code> or <code>onlyTrashed</code>.
</p>

</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/permissions-users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"raison":"rerum","dateDepart":"2025-11-22T14:46:49+0000","dateRetour":"2025-11-22T14:46:49+0000","duration":18,"idUserApprove":9,"status":"in_progress"}'

```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "raison": "rerum",
    "dateDepart": "2025-11-22T14:46:49+0000",
    "dateRetour": "2025-11-22T14:46:49+0000",
    "duration": 18,
    "idUserApprove": 9,
    "status": "in_progress"
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
    'http://localhost/api/permissions-users',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'raison' => 'rerum',
            'dateDepart' => '2025-11-22T14:46:49+0000',
            'dateRetour' => '2025-11-22T14:46:49+0000',
            'duration' => 18,
            'idUserApprove' => 9,
            'status' => 'in_progress',
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
<div id="execution-results-POSTapi-permissions-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-permissions-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-permissions-users"></code></pre>
</div>
<div id="execution-error-POSTapi-permissions-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-permissions-users"></code></pre>
</div>
<form id="form-POSTapi-permissions-users" data-method="POST" data-path="api/permissions-users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-permissions-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/permissions-users</code></b>
</p>
<p>
<label id="auth-POSTapi-permissions-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-permissions-users" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>raison</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="raison" data-endpoint="POSTapi-permissions-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>dateDepart</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="dateDepart" data-endpoint="POSTapi-permissions-users" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>dateRetour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="dateRetour" data-endpoint="POSTapi-permissions-users" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="duration" data-endpoint="POSTapi-permissions-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-permissions-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-permissions-users" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/permissions-users/porro" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users/porro"
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
    'http://localhost/api/permissions-users/porro',
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
<div id="execution-results-GETapi-permissions-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-permissions-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-permissions-users--id-"></code></pre>
</div>
<div id="execution-error-GETapi-permissions-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-permissions-users--id-"></code></pre>
</div>
<form id="form-GETapi-permissions-users--id-" data-method="GET" data-path="api/permissions-users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-permissions-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/permissions-users/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-permissions-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-permissions-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-permissions-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/permissions-users/facilis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"raison":"architecto","dateDepart":"2025-11-22T14:46:49+0000","dateRetour":"2025-11-22T14:46:49+0000","duration":14,"status":"animi"}'

```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users/facilis"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "raison": "architecto",
    "dateDepart": "2025-11-22T14:46:49+0000",
    "dateRetour": "2025-11-22T14:46:49+0000",
    "duration": 14,
    "status": "animi"
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
    'http://localhost/api/permissions-users/facilis',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'raison' => 'architecto',
            'dateDepart' => '2025-11-22T14:46:49+0000',
            'dateRetour' => '2025-11-22T14:46:49+0000',
            'duration' => 14,
            'status' => 'animi',
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
<div id="execution-results-PUTapi-permissions-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-permissions-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-permissions-users--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-permissions-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-permissions-users--id-"></code></pre>
</div>
<form id="form-PUTapi-permissions-users--id-" data-method="PUT" data-path="api/permissions-users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-permissions-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/permissions-users/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-permissions-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-permissions-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-permissions-users--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>raison</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="raison" data-endpoint="PUTapi-permissions-users--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>dateDepart</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="dateDepart" data-endpoint="PUTapi-permissions-users--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>dateRetour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="dateRetour" data-endpoint="PUTapi-permissions-users--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="duration" data-endpoint="PUTapi-permissions-users--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-permissions-users--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Soft delete the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/permissions-users/trash/totam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users/trash/totam"
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
    'http://localhost/api/permissions-users/trash/totam',
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
<div id="execution-results-DELETEapi-permissions-users-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-permissions-users-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-permissions-users-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-permissions-users-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-permissions-users-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-permissions-users-trash--id-" data-method="DELETE" data-path="api/permissions-users/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-permissions-users-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/permissions-users/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-permissions-users-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-permissions-users-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-permissions-users-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restore the specified soft deleted resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/permissions-users/restore/quaerat" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users/restore/quaerat"
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
    'http://localhost/api/permissions-users/restore/quaerat',
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
<div id="execution-results-POSTapi-permissions-users-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-permissions-users-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-permissions-users-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-permissions-users-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-permissions-users-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-permissions-users-restore--id-" data-method="POST" data-path="api/permissions-users/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-permissions-users-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/permissions-users/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-permissions-users-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-permissions-users-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-permissions-users-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Remove the specified resource from storage permanently.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/permissions-users/delete/sapiente" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions-users/delete/sapiente"
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
    'http://localhost/api/permissions-users/delete/sapiente',
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
<div id="execution-results-DELETEapi-permissions-users-delete--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-permissions-users-delete--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-permissions-users-delete--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-permissions-users-delete--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-permissions-users-delete--id-"></code></pre>
</div>
<form id="form-DELETEapi-permissions-users-delete--id-" data-method="DELETE" data-path="api/permissions-users/delete/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-permissions-users-delete--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/permissions-users/delete/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-permissions-users-delete--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-permissions-users-delete--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-permissions-users-delete--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Liste des produits

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/productsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":13,"nbreItems":1,"filter_value":"eius","type":"voluptatem","trashed":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/productsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 13,
    "nbreItems": 1,
    "filter_value": "eius",
    "type": "voluptatem",
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
    'http://localhost/api/productsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 13,
            'nbreItems' => 1,
            'filter_value' => 'eius',
            'type' => 'voluptatem',
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
<div id="execution-results-POSTapi-productsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-productsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-productsall"></code></pre>
</div>
<div id="execution-error-POSTapi-productsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-productsall"></code></pre>
</div>
<form id="form-POSTapi-productsall" data-method="POST" data-path="api/productsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-productsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/productsall</code></b>
</p>
<p>
<label id="auth-POSTapi-productsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-productsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-productsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-productsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-productsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-productsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-productsall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-productsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-productsall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-productsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer un ou plusieurs produits

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/products" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"products":[{"name":"consectetur","description":"dignissimos","price":298870071.31786,"type":"omnis"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/products"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "products": [
        {
            "name": "consectetur",
            "description": "dignissimos",
            "price": 298870071.31786,
            "type": "omnis"
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
    'http://localhost/api/products',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'products' => [
                [
                    'name' => 'consectetur',
                    'description' => 'dignissimos',
                    'price' => 298870071.31786,
                    'type' => 'omnis',
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
<div id="execution-results-POSTapi-products" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-products"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products"></code></pre>
</div>
<div id="execution-error-POSTapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products"></code></pre>
</div>
<form id="form-POSTapi-products" data-method="POST" data-path="api/products" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-products', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/products</code></b>
</p>
<p>
<label id="auth-POSTapi-products" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-products" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>products</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>products[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="products.0.name" data-endpoint="POSTapi-products" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>products[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="products.0.description" data-endpoint="POSTapi-products" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>products[].price</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="products.0.price" data-endpoint="POSTapi-products" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>products[].type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="products.0.type" data-endpoint="POSTapi-products" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un produit

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/products/corporis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/products/corporis"
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
    'http://localhost/api/products/corporis',
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
<div id="execution-results-GETapi-products--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-products--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products--id-"></code></pre>
</div>
<div id="execution-error-GETapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products--id-"></code></pre>
</div>
<form id="form-GETapi-products--id-" data-method="GET" data-path="api/products/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-products--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/products/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-products--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-products--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-products--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour les infos d&#039;un produit

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/products/ea" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"provident","description":"cumque","price":40332182.4,"type":"voluptatem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/products/ea"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "provident",
    "description": "cumque",
    "price": 40332182.4,
    "type": "voluptatem"
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
    'http://localhost/api/products/ea',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'provident',
            'description' => 'cumque',
            'price' => 40332182.4,
            'type' => 'voluptatem',
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
<div id="execution-results-PUTapi-products--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-products--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-products--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-products--id-"></code></pre>
</div>
<form id="form-PUTapi-products--id-" data-method="PUT" data-path="api/products/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-products--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/products/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-products--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-products--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-products--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-products--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-products--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="price" data-endpoint="PUTapi-products--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-products--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Mettre un ou plusieurs produits en corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/products/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idProducts":["rerum",null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/products/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idProducts": [
        "rerum",
        null
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
    'http://localhost/api/products/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idProducts' => [
                'rerum',
                null,
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
<div id="execution-results-POSTapi-products-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-products-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-products-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products-trash"></code></pre>
</div>
<form id="form-POSTapi-products-trash" data-method="POST" data-path="api/products/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-products-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/products/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-products-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-products-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idProducts</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="idProducts.0" data-endpoint="POSTapi-products-trash" data-component="body" required  hidden>
<input type="text" name="idProducts.1" data-endpoint="POSTapi-products-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer un ou plusieurs produits de la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/products/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idProducts":["ducimus",null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/products/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idProducts": [
        "ducimus",
        null
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
    'http://localhost/api/products/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idProducts' => [
                'ducimus',
                null,
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
<div id="execution-results-POSTapi-products-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-products-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-products-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products-restore"></code></pre>
</div>
<form id="form-POSTapi-products-restore" data-method="POST" data-path="api/products/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-products-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/products/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-products-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-products-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idProducts</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="idProducts.0" data-endpoint="POSTapi-products-restore" data-component="body" required  hidden>
<input type="text" name="idProducts.1" data-endpoint="POSTapi-products-restore" data-component="body" hidden>
<br>

</p>

</form>


## Remove the specified resource from storage permanently.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/products/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idProducts":["unde",null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/products/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idProducts": [
        "unde",
        null
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
    'http://localhost/api/products/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idProducts' => [
                'unde',
                null,
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
<div id="execution-results-POSTapi-products-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-products-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-products-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products-delete"></code></pre>
</div>
<form id="form-POSTapi-products-delete" data-method="POST" data-path="api/products/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-products-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/products/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-products-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-products-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idProducts</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="idProducts.0" data-endpoint="POSTapi-products-delete" data-component="body" required  hidden>
<input type="text" name="idProducts.1" data-endpoint="POSTapi-products-delete" data-component="body" hidden>
<br>

</p>

</form>


## Lister les congés enregistrés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/holidaysall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":11,"idUserApprove":19,"status":"rejected","trashed":false,"date":"2025-11-22","pageItems":12,"nbreItems":20,"filter_value":"odit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidaysall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 11,
    "idUserApprove": 19,
    "status": "rejected",
    "trashed": false,
    "date": "2025-11-22",
    "pageItems": 12,
    "nbreItems": 20,
    "filter_value": "odit"
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
    'http://localhost/api/holidaysall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 11,
            'idUserApprove' => 19,
            'status' => 'rejected',
            'trashed' => false,
            'date' => '2025-11-22',
            'pageItems' => 12,
            'nbreItems' => 20,
            'filter_value' => 'odit',
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
<div id="execution-results-POSTapi-holidaysall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-holidaysall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-holidaysall"></code></pre>
</div>
<div id="execution-error-POSTapi-holidaysall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-holidaysall"></code></pre>
</div>
<form id="form-POSTapi-holidaysall" data-method="POST" data-path="api/holidaysall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-holidaysall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/holidaysall</code></b>
</p>
<p>
<label id="auth-POSTapi-holidaysall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-holidaysall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-holidaysall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-holidaysall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-holidaysall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-holidaysall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-holidaysall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer une demande de congé

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/holidays" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"quis","start_date":"2025-11-22","end_date":"2025-11-22","days_taken":5,"reason":"esse","idUserApprove":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidays"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "quis",
    "start_date": "2025-11-22",
    "end_date": "2025-11-22",
    "days_taken": 5,
    "reason": "esse",
    "idUserApprove": 20
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
    'http://localhost/api/holidays',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type' => 'quis',
            'start_date' => '2025-11-22',
            'end_date' => '2025-11-22',
            'days_taken' => 5,
            'reason' => 'esse',
            'idUserApprove' => 20,
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
<div id="execution-results-POSTapi-holidays" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-holidays"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-holidays"></code></pre>
</div>
<div id="execution-error-POSTapi-holidays" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-holidays"></code></pre>
</div>
<form id="form-POSTapi-holidays" data-method="POST" data-path="api/holidays" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-holidays', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/holidays</code></b>
</p>
<p>
<label id="auth-POSTapi-holidays" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-holidays" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="start_date" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="end_date" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>days_taken</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="days_taken" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-holidays" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une retenue sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/holidays/consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/holidays/consequatur"
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
    'http://localhost/api/holidays/consequatur',
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
<div id="execution-results-GETapi-holidays--holiday-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-holidays--holiday-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-holidays--holiday-"></code></pre>
</div>
<div id="execution-error-GETapi-holidays--holiday-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-holidays--holiday-"></code></pre>
</div>
<form id="form-GETapi-holidays--holiday-" data-method="GET" data-path="api/holidays/{holiday}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-holidays--holiday-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/holidays/{holiday}</code></b>
</p>
<p>
<label id="auth-GETapi-holidays--holiday-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-holidays--holiday-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>holiday</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="holiday" data-endpoint="GETapi-holidays--holiday-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier une demande de congé

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/holidays/vero" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"saepe","start_date":"2025-11-22","end_date":"2025-11-22","days_taken":8,"reason":"et","status":"rejected"}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidays/vero"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "saepe",
    "start_date": "2025-11-22",
    "end_date": "2025-11-22",
    "days_taken": 8,
    "reason": "et",
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
    'http://localhost/api/holidays/vero',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type' => 'saepe',
            'start_date' => '2025-11-22',
            'end_date' => '2025-11-22',
            'days_taken' => 8,
            'reason' => 'et',
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
<div id="execution-results-PUTapi-holidays--holiday-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-holidays--holiday-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-holidays--holiday-"></code></pre>
</div>
<div id="execution-error-PUTapi-holidays--holiday-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-holidays--holiday-"></code></pre>
</div>
<form id="form-PUTapi-holidays--holiday-" data-method="PUT" data-path="api/holidays/{holiday}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-holidays--holiday-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/holidays/{holiday}</code></b>
</p>
<p>
<label id="auth-PUTapi-holidays--holiday-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-holidays--holiday-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>holiday</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="holiday" data-endpoint="PUTapi-holidays--holiday-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>days_taken</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="days_taken" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-holidays--holiday-" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>

</form>


## Archiver une ou plusieurs demandes de congés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/holidays/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idHolidays":[7,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidays/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idHolidays": [
        7,
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
    'http://localhost/api/holidays/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idHolidays' => [
                7,
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
<div id="execution-results-POSTapi-holidays-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-holidays-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-holidays-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-holidays-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-holidays-trash"></code></pre>
</div>
<form id="form-POSTapi-holidays-trash" data-method="POST" data-path="api/holidays/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-holidays-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/holidays/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-holidays-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-holidays-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idHolidays</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idHolidays.0" data-endpoint="POSTapi-holidays-trash" data-component="body" required  hidden>
<input type="number" name="idHolidays.1" data-endpoint="POSTapi-holidays-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer une ou plusieurs demandes de congés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/holidays/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idHolidays":[19,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidays/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idHolidays": [
        19,
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
    'http://localhost/api/holidays/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idHolidays' => [
                19,
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
<div id="execution-results-POSTapi-holidays-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-holidays-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-holidays-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-holidays-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-holidays-restore"></code></pre>
</div>
<form id="form-POSTapi-holidays-restore" data-method="POST" data-path="api/holidays/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-holidays-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/holidays/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-holidays-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-holidays-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idHolidays</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idHolidays.0" data-endpoint="POSTapi-holidays-restore" data-component="body" required  hidden>
<input type="number" name="idHolidays.1" data-endpoint="POSTapi-holidays-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer une ou plusieurs demandes de congés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/holidays/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idHolidays":[19,13]}'

```

```javascript
const url = new URL(
    "http://localhost/api/holidays/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idHolidays": [
        19,
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
    'http://localhost/api/holidays/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idHolidays' => [
                19,
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
<div id="execution-results-POSTapi-holidays-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-holidays-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-holidays-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-holidays-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-holidays-delete"></code></pre>
</div>
<form id="form-POSTapi-holidays-delete" data-method="POST" data-path="api/holidays/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-holidays-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/holidays/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-holidays-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-holidays-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idHolidays</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idHolidays.0" data-endpoint="POSTapi-holidays-delete" data-component="body" required  hidden>
<input type="number" name="idHolidays.1" data-endpoint="POSTapi-holidays-delete" data-component="body" hidden>
<br>

</p>

</form>


## Lister les bonus enregistrés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bonusesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":10,"idUserApprove":3,"bonus_type":"student","status":"in_progress","is_used":false,"trashed":false,"pageItems":9,"nbreItems":9,"filter_value":"dicta"}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonusesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 10,
    "idUserApprove": 3,
    "bonus_type": "student",
    "status": "in_progress",
    "is_used": false,
    "trashed": false,
    "pageItems": 9,
    "nbreItems": 9,
    "filter_value": "dicta"
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
    'http://localhost/api/bonusesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 10,
            'idUserApprove' => 3,
            'bonus_type' => 'student',
            'status' => 'in_progress',
            'is_used' => false,
            'trashed' => false,
            'pageItems' => 9,
            'nbreItems' => 9,
            'filter_value' => 'dicta',
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
<div id="execution-results-POSTapi-bonusesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bonusesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bonusesall"></code></pre>
</div>
<div id="execution-error-POSTapi-bonusesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bonusesall"></code></pre>
</div>
<form id="form-POSTapi-bonusesall" data-method="POST" data-path="api/bonusesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bonusesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bonusesall</code></b>
</p>
<p>
<label id="auth-POSTapi-bonusesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bonusesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bonus_type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bonus_type" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>
The value must be one of <code>student</code> or <code>staff</code>.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>is_used</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-bonusesall" hidden><input type="radio" name="is_used" value="true" data-endpoint="POSTapi-bonusesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-bonusesall" hidden><input type="radio" name="is_used" value="false" data-endpoint="POSTapi-bonusesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-bonusesall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-bonusesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-bonusesall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-bonusesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-bonusesall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer un ou plusieurs bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bonuses" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"bonuses":[{"idUser":9,"idUserApprove":5,"bonus_type":"staff","amount":46162.56938,"reason":"molestiae","is_used":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonuses"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bonuses": [
        {
            "idUser": 9,
            "idUserApprove": 5,
            "bonus_type": "staff",
            "amount": 46162.56938,
            "reason": "molestiae",
            "is_used": false
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
    'http://localhost/api/bonuses',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'bonuses' => [
                [
                    'idUser' => 9,
                    'idUserApprove' => 5,
                    'bonus_type' => 'staff',
                    'amount' => 46162.56938,
                    'reason' => 'molestiae',
                    'is_used' => false,
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
<div id="execution-results-POSTapi-bonuses" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bonuses"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bonuses"></code></pre>
</div>
<div id="execution-error-POSTapi-bonuses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bonuses"></code></pre>
</div>
<form id="form-POSTapi-bonuses" data-method="POST" data-path="api/bonuses" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bonuses', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bonuses</code></b>
</p>
<p>
<label id="auth-POSTapi-bonuses" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bonuses" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>bonuses</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>bonuses[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="bonuses.0.idUser" data-endpoint="POSTapi-bonuses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>bonuses[].idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="bonuses.0.idUserApprove" data-endpoint="POSTapi-bonuses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>bonuses[].bonus_type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="bonuses.0.bonus_type" data-endpoint="POSTapi-bonuses" data-component="body" required  hidden>
<br>
The value must be one of <code>student</code> or <code>staff</code>.
</p>
<p>
<b><code>bonuses[].amount</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="bonuses.0.amount" data-endpoint="POSTapi-bonuses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>bonuses[].reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="bonuses.0.reason" data-endpoint="POSTapi-bonuses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>bonuses[].is_used</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-bonuses" hidden><input type="radio" name="bonuses.0.is_used" value="true" data-endpoint="POSTapi-bonuses" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-bonuses" hidden><input type="radio" name="bonuses.0.is_used" value="false" data-endpoint="POSTapi-bonuses" data-component="body" ><code>false</code></label>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/bonuses/sit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/bonuses/sit"
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
    'http://localhost/api/bonuses/sit',
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
<div id="execution-results-GETapi-bonuses--bonus-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-bonuses--bonus-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-bonuses--bonus-"></code></pre>
</div>
<div id="execution-error-GETapi-bonuses--bonus-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-bonuses--bonus-"></code></pre>
</div>
<form id="form-GETapi-bonuses--bonus-" data-method="GET" data-path="api/bonuses/{bonus}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-bonuses--bonus-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/bonuses/{bonus}</code></b>
</p>
<p>
<label id="auth-GETapi-bonuses--bonus-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-bonuses--bonus-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>bonus</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="bonus" data-endpoint="GETapi-bonuses--bonus-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier un bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/bonuses/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":2,"idUserApprove":20,"bonus_type":"student","amount":0.7,"reason":"voluptas","is_used":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonuses/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 2,
    "idUserApprove": 20,
    "bonus_type": "student",
    "amount": 0.7,
    "reason": "voluptas",
    "is_used": false
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
    'http://localhost/api/bonuses/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 2,
            'idUserApprove' => 20,
            'bonus_type' => 'student',
            'amount' => 0.7,
            'reason' => 'voluptas',
            'is_used' => false,
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
<div id="execution-results-PUTapi-bonuses--bonus-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-bonuses--bonus-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-bonuses--bonus-"></code></pre>
</div>
<div id="execution-error-PUTapi-bonuses--bonus-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-bonuses--bonus-"></code></pre>
</div>
<form id="form-PUTapi-bonuses--bonus-" data-method="PUT" data-path="api/bonuses/{bonus}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-bonuses--bonus-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/bonuses/{bonus}</code></b>
</p>
<p>
<label id="auth-PUTapi-bonuses--bonus-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-bonuses--bonus-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>bonus</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="bonus" data-endpoint="PUTapi-bonuses--bonus-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-bonuses--bonus-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="PUTapi-bonuses--bonus-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bonus_type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bonus_type" data-endpoint="PUTapi-bonuses--bonus-" data-component="body"  hidden>
<br>
The value must be one of <code>student</code> or <code>staff</code>.
</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount" data-endpoint="PUTapi-bonuses--bonus-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-bonuses--bonus-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>is_used</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-bonuses--bonus-" hidden><input type="radio" name="is_used" value="true" data-endpoint="PUTapi-bonuses--bonus-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-bonuses--bonus-" hidden><input type="radio" name="is_used" value="false" data-endpoint="PUTapi-bonuses--bonus-" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Archiver un ou plusieurs bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bonuses/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idBonuses":[10,8]}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonuses/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idBonuses": [
        10,
        8
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
    'http://localhost/api/bonuses/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idBonuses' => [
                10,
                8,
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
<div id="execution-results-POSTapi-bonuses-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bonuses-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bonuses-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-bonuses-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bonuses-trash"></code></pre>
</div>
<form id="form-POSTapi-bonuses-trash" data-method="POST" data-path="api/bonuses/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bonuses-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bonuses/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-bonuses-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bonuses-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idBonuses</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idBonuses.0" data-endpoint="POSTapi-bonuses-trash" data-component="body" required  hidden>
<input type="number" name="idBonuses.1" data-endpoint="POSTapi-bonuses-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer une ou plusieurs bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bonuses/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idBonuses":[15,1]}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonuses/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idBonuses": [
        15,
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
    'http://localhost/api/bonuses/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idBonuses' => [
                15,
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
<div id="execution-results-POSTapi-bonuses-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bonuses-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bonuses-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-bonuses-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bonuses-restore"></code></pre>
</div>
<form id="form-POSTapi-bonuses-restore" data-method="POST" data-path="api/bonuses/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bonuses-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bonuses/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-bonuses-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bonuses-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idBonuses</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idBonuses.0" data-endpoint="POSTapi-bonuses-restore" data-component="body" required  hidden>
<input type="number" name="idBonuses.1" data-endpoint="POSTapi-bonuses-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer un ou plusieurs bonus

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bonuses/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idBonuses":[14,7]}'

```

```javascript
const url = new URL(
    "http://localhost/api/bonuses/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idBonuses": [
        14,
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
    'http://localhost/api/bonuses/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idBonuses' => [
                14,
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
<div id="execution-results-POSTapi-bonuses-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bonuses-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bonuses-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-bonuses-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bonuses-delete"></code></pre>
</div>
<form id="form-POSTapi-bonuses-delete" data-method="POST" data-path="api/bonuses/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bonuses-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bonuses/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-bonuses-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bonuses-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idBonuses</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idBonuses.0" data-endpoint="POSTapi-bonuses-delete" data-component="body" required  hidden>
<input type="number" name="idBonuses.1" data-endpoint="POSTapi-bonuses-delete" data-component="body" hidden>
<br>

</p>

</form>


## Lister les résumés de leçons enregistrés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summariesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idLesson":15,"idChapter":3,"idModule":8,"idClasse":16,"idTeacher":9,"trashed":false,"pageItems":14,"nbreItems":4,"filter_value":"qui","date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summariesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idLesson": 15,
    "idChapter": 3,
    "idModule": 8,
    "idClasse": 16,
    "idTeacher": 9,
    "trashed": false,
    "pageItems": 14,
    "nbreItems": 4,
    "filter_value": "qui",
    "date": "2025-11-22"
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
    'http://localhost/api/lessons-summariesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idLesson' => 15,
            'idChapter' => 3,
            'idModule' => 8,
            'idClasse' => 16,
            'idTeacher' => 9,
            'trashed' => false,
            'pageItems' => 14,
            'nbreItems' => 4,
            'filter_value' => 'qui',
            'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-lessons-summariesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summariesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summariesall"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summariesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summariesall"></code></pre>
</div>
<form id="form-POSTapi-lessons-summariesall" data-method="POST" data-path="api/lessons-summariesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summariesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summariesall</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summariesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summariesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLesson" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idChapter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idChapter" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idModule</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idModule" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-lessons-summariesall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-lessons-summariesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-lessons-summariesall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-lessons-summariesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-lessons-summariesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Ajouter un ou plusieurs résumés de leçon

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summaries" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"lesson_summaries":[{"idLesson":10,"description":"eveniet","images":["iusto","qui"],"date":"2025-11-22"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lesson_summaries": [
        {
            "idLesson": 10,
            "description": "eveniet",
            "images": [
                "iusto",
                "qui"
            ],
            "date": "2025-11-22"
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
    'http://localhost/api/lessons-summaries',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'lesson_summaries' => [
                [
                    'idLesson' => 10,
                    'description' => 'eveniet',
                    'images' => [
                        'iusto',
                        'qui',
                    ],
                    'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-lessons-summaries" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summaries"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summaries"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summaries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summaries"></code></pre>
</div>
<form id="form-POSTapi-lessons-summaries" data-method="POST" data-path="api/lessons-summaries" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summaries', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summaries</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summaries" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summaries" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>lesson_summaries</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>lesson_summaries[].idLesson</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="lesson_summaries.0.idLesson" data-endpoint="POSTapi-lessons-summaries" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>lesson_summaries[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lesson_summaries.0.description" data-endpoint="POSTapi-lessons-summaries" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>lesson_summaries[].images</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="lesson_summaries.0.images.0" data-endpoint="POSTapi-lessons-summaries" data-component="body" required  hidden>
<input type="text" name="lesson_summaries.0.images.1" data-endpoint="POSTapi-lessons-summaries" data-component="body" hidden>
<br>

</p>
<p>
<b><code>lesson_summaries[].date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="lesson_summaries.0.date" data-endpoint="POSTapi-lessons-summaries" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un résumé d&#039;une leçon

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/lessons-summaries/laborum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/laborum"
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
    'http://localhost/api/lessons-summaries/laborum',
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
<div id="execution-results-GETapi-lessons-summaries--lesson_summary-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-lessons-summaries--lesson_summary-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-lessons-summaries--lesson_summary-"></code></pre>
</div>
<div id="execution-error-GETapi-lessons-summaries--lesson_summary-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-lessons-summaries--lesson_summary-"></code></pre>
</div>
<form id="form-GETapi-lessons-summaries--lesson_summary-" data-method="GET" data-path="api/lessons-summaries/{lesson_summary}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-lessons-summaries--lesson_summary-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/lessons-summaries/{lesson_summary}</code></b>
</p>
<p>
<label id="auth-GETapi-lessons-summaries--lesson_summary-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-lessons-summaries--lesson_summary-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>lesson_summary</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lesson_summary" data-endpoint="GETapi-lessons-summaries--lesson_summary-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier un résumé de leçon

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/lessons-summaries/quidem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idLesson":15,"description":"suscipit","images":["ex","voluptas"],"date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/quidem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idLesson": 15,
    "description": "suscipit",
    "images": [
        "ex",
        "voluptas"
    ],
    "date": "2025-11-22"
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
    'http://localhost/api/lessons-summaries/quidem',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idLesson' => 15,
            'description' => 'suscipit',
            'images' => [
                'ex',
                'voluptas',
            ],
            'date' => '2025-11-22',
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
<div id="execution-results-PUTapi-lessons-summaries--lesson_summary-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-lessons-summaries--lesson_summary-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-lessons-summaries--lesson_summary-"></code></pre>
</div>
<div id="execution-error-PUTapi-lessons-summaries--lesson_summary-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-lessons-summaries--lesson_summary-"></code></pre>
</div>
<form id="form-PUTapi-lessons-summaries--lesson_summary-" data-method="PUT" data-path="api/lessons-summaries/{lesson_summary}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-lessons-summaries--lesson_summary-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/lessons-summaries/{lesson_summary}</code></b>
</p>
<p>
<label id="auth-PUTapi-lessons-summaries--lesson_summary-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>lesson_summary</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lesson_summary" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLesson" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>images</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="images.0" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="body" required  hidden>
<input type="text" name="images.1" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="body" hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-lessons-summaries--lesson_summary-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Archiver un ou plusieurs résumés de leçons

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summaries/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[{},null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        {},
        null
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
    'http://localhost/api/lessons-summaries/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                [],
                null,
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
<div id="execution-results-POSTapi-lessons-summaries-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summaries-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summaries-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summaries-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summaries-trash"></code></pre>
</div>
<form id="form-POSTapi-lessons-summaries-trash" data-method="POST" data-path="api/lessons-summaries/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summaries-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summaries/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summaries-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summaries-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="ids.0" data-endpoint="POSTapi-lessons-summaries-trash" data-component="body"  hidden>
<input type="text" name="ids.1" data-endpoint="POSTapi-lessons-summaries-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer un ou plusieurs résumé(s) de leçons

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summaries/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[{},null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        {},
        null
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
    'http://localhost/api/lessons-summaries/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                [],
                null,
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
<div id="execution-results-POSTapi-lessons-summaries-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summaries-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summaries-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summaries-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summaries-restore"></code></pre>
</div>
<form id="form-POSTapi-lessons-summaries-restore" data-method="POST" data-path="api/lessons-summaries/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summaries-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summaries/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summaries-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summaries-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="ids.0" data-endpoint="POSTapi-lessons-summaries-restore" data-component="body"  hidden>
<input type="text" name="ids.1" data-endpoint="POSTapi-lessons-summaries-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer un ou plusieurs résumés de leçons

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summaries/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[{},null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        {},
        null
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
    'http://localhost/api/lessons-summaries/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                [],
                null,
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
<div id="execution-results-POSTapi-lessons-summaries-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summaries-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summaries-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summaries-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summaries-delete"></code></pre>
</div>
<form id="form-POSTapi-lessons-summaries-delete" data-method="POST" data-path="api/lessons-summaries/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summaries-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summaries/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summaries-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summaries-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="ids.0" data-endpoint="POSTapi-lessons-summaries-delete" data-component="body"  hidden>
<input type="text" name="ids.1" data-endpoint="POSTapi-lessons-summaries-delete" data-component="body" hidden>
<br>

</p>

</form>


## Téléchargement PDF des résumés de leçon

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/lessons-summaries/download" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idLesson":"voluptas","idLessonSummary":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/lessons-summaries/download"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idLesson": "voluptas",
    "idLessonSummary": {}
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
    'http://localhost/api/lessons-summaries/download',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idLesson' => 'voluptas',
            'idLessonSummary' => [],
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
<div id="execution-results-POSTapi-lessons-summaries-download" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-lessons-summaries-download"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lessons-summaries-download"></code></pre>
</div>
<div id="execution-error-POSTapi-lessons-summaries-download" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lessons-summaries-download"></code></pre>
</div>
<form id="form-POSTapi-lessons-summaries-download" data-method="POST" data-path="api/lessons-summaries/download" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-lessons-summaries-download', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/lessons-summaries/download</code></b>
</p>
<p>
<label id="auth-POSTapi-lessons-summaries-download" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-lessons-summaries-download" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLesson" data-endpoint="POSTapi-lessons-summaries-download" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idLessonSummary</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idLessonSummary" data-endpoint="POSTapi-lessons-summaries-download" data-component="body"  hidden>
<br>

</p>

</form>


## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgetsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":3,"nbreItems":19,"filter_value":"aut","idSchool":20,"type":"velit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgetsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 3,
    "nbreItems": 19,
    "filter_value": "aut",
    "idSchool": 20,
    "type": "velit"
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
    'http://localhost/api/budgetsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 3,
            'nbreItems' => 19,
            'filter_value' => 'aut',
            'idSchool' => 20,
            'type' => 'velit',
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
<div id="execution-results-POSTapi-budgetsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgetsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgetsall"></code></pre>
</div>
<div id="execution-error-POSTapi-budgetsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgetsall"></code></pre>
</div>
<form id="form-POSTapi-budgetsall" data-method="POST" data-path="api/budgetsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgetsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgetsall</code></b>
</p>
<p>
<label id="auth-POSTapi-budgetsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgetsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-budgetsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-budgetsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-budgetsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-budgetsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-budgetsall" data-component="body"  hidden>
<br>

</p>

</form>


## Show the form for creating a new resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgets" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"dolores","type":"Invoice","description":"nobis","realisation":1777616.834773,"idSchool":14,"type_invoice_or_type_recipe_items":[{"item_id":18,"quantity":10,"number":36334.9126175,"amount":63.629345499}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgets"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "dolores",
    "type": "Invoice",
    "description": "nobis",
    "realisation": 1777616.834773,
    "idSchool": 14,
    "type_invoice_or_type_recipe_items": [
        {
            "item_id": 18,
            "quantity": 10,
            "number": 36334.9126175,
            "amount": 63.629345499
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
    'http://localhost/api/budgets',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'dolores',
            'type' => 'Invoice',
            'description' => 'nobis',
            'realisation' => 1777616.834773,
            'idSchool' => 14,
            'type_invoice_or_type_recipe_items' => [
                [
                    'item_id' => 18,
                    'quantity' => 10,
                    'number' => 36334.9126175,
                    'amount' => 63.629345499,
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
<div id="execution-results-POSTapi-budgets" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgets"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgets"></code></pre>
</div>
<div id="execution-error-POSTapi-budgets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgets"></code></pre>
</div>
<form id="form-POSTapi-budgets" data-method="POST" data-path="api/budgets" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgets', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgets</code></b>
</p>
<p>
<label id="auth-POSTapi-budgets" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgets" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-budgets" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-budgets" data-component="body" required  hidden>
<br>
The value must be one of <code>Invoice</code> or <code>Recipe</code>.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>realisation</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="realisation" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>type_invoice_or_type_recipe_items</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>type_invoice_or_type_recipe_items[].item_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.item_id" data-endpoint="POSTapi-budgets" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.quantity" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].number</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.number" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.amount" data-endpoint="POSTapi-budgets" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/budgets/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/budgets/sed"
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
    'http://localhost/api/budgets/sed',
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
<div id="execution-results-GETapi-budgets--budget-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-budgets--budget-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-budgets--budget-"></code></pre>
</div>
<div id="execution-error-GETapi-budgets--budget-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-budgets--budget-"></code></pre>
</div>
<form id="form-GETapi-budgets--budget-" data-method="GET" data-path="api/budgets/{budget}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-budgets--budget-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/budgets/{budget}</code></b>
</p>
<p>
<label id="auth-GETapi-budgets--budget-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-budgets--budget-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>budget</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="budget" data-endpoint="GETapi-budgets--budget-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/budgets/voluptatem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"quidem","type":"Invoice","description":"sint","realisation":2113.1018894,"idSchool":2,"type_invoice_or_type_recipe_items":[{"item_id":14,"quantity":12,"number":513246.6,"amount":253077849.285}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgets/voluptatem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "quidem",
    "type": "Invoice",
    "description": "sint",
    "realisation": 2113.1018894,
    "idSchool": 2,
    "type_invoice_or_type_recipe_items": [
        {
            "item_id": 14,
            "quantity": 12,
            "number": 513246.6,
            "amount": 253077849.285
        }
    ]
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
    'http://localhost/api/budgets/voluptatem',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'quidem',
            'type' => 'Invoice',
            'description' => 'sint',
            'realisation' => 2113.1018894,
            'idSchool' => 2,
            'type_invoice_or_type_recipe_items' => [
                [
                    'item_id' => 14,
                    'quantity' => 12,
                    'number' => 513246.6,
                    'amount' => 253077849.285,
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
<div id="execution-results-PUTapi-budgets--budget-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-budgets--budget-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-budgets--budget-"></code></pre>
</div>
<div id="execution-error-PUTapi-budgets--budget-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-budgets--budget-"></code></pre>
</div>
<form id="form-PUTapi-budgets--budget-" data-method="PUT" data-path="api/budgets/{budget}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-budgets--budget-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/budgets/{budget}</code></b>
</p>
<p>
<label id="auth-PUTapi-budgets--budget-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-budgets--budget-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>budget</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="budget" data-endpoint="PUTapi-budgets--budget-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>
The value must be one of <code>Invoice</code> or <code>Recipe</code>.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>realisation</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="realisation" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>type_invoice_or_type_recipe_items</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>type_invoice_or_type_recipe_items[].item_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.item_id" data-endpoint="PUTapi-budgets--budget-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.quantity" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].number</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.number" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoice_or_type_recipe_items[].amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoice_or_type_recipe_items.0.amount" data-endpoint="PUTapi-budgets--budget-" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Fonction pour le multiple archivage des budgets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgets/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[7,6]}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgets/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        7,
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
    'http://localhost/api/budgets/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                7,
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
<div id="execution-results-POSTapi-budgets-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgets-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgets-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-budgets-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgets-trash"></code></pre>
</div>
<form id="form-POSTapi-budgets-trash" data-method="POST" data-path="api/budgets/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgets-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgets/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-budgets-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgets-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-budgets-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-budgets-trash" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de restauration multiples des budgets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgets/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[11,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgets/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        11,
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
    'http://localhost/api/budgets/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                11,
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
<div id="execution-results-POSTapi-budgets-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgets-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgets-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-budgets-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgets-restore"></code></pre>
</div>
<form id="form-POSTapi-budgets-restore" data-method="POST" data-path="api/budgets/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgets-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgets/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-budgets-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgets-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-budgets-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-budgets-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des budgets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgets/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[3,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/budgets/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        3,
        5
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
    'http://localhost/api/budgets/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                3,
                5,
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
<div id="execution-results-POSTapi-budgets-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgets-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgets-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-budgets-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgets-delete"></code></pre>
</div>
<form id="form-POSTapi-budgets-delete" data-method="POST" data-path="api/budgets/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgets-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgets/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-budgets-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgets-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-budgets-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-budgets-delete" data-component="body" hidden>
<br>

</p>

</form>


## api/budgets/progress

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/budgets/progress" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/budgets/progress"
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
    'http://localhost/api/budgets/progress',
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
<div id="execution-results-POSTapi-budgets-progress" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-budgets-progress"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-budgets-progress"></code></pre>
</div>
<div id="execution-error-POSTapi-budgets-progress" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-budgets-progress"></code></pre>
</div>
<form id="form-POSTapi-budgets-progress" data-method="POST" data-path="api/budgets/progress" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-budgets-progress', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/budgets/progress</code></b>
</p>
<p>
<label id="auth-POSTapi-budgets-progress" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-budgets-progress" data-component="header"></label>
</p>
</form>


## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/type-of-recipesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":11,"nbreItems":6,"filter_value":"nisi","name":"aut","category":"et","school_id":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 11,
    "nbreItems": 6,
    "filter_value": "nisi",
    "name": "aut",
    "category": "et",
    "school_id": 11
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
    'http://localhost/api/type-of-recipesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 11,
            'nbreItems' => 6,
            'filter_value' => 'nisi',
            'name' => 'aut',
            'category' => 'et',
            'school_id' => 11,
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
<div id="execution-results-POSTapi-type-of-recipesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-type-of-recipesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-type-of-recipesall"></code></pre>
</div>
<div id="execution-error-POSTapi-type-of-recipesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-type-of-recipesall"></code></pre>
</div>
<form id="form-POSTapi-type-of-recipesall" data-method="POST" data-path="api/type-of-recipesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-type-of-recipesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/type-of-recipesall</code></b>
</p>
<p>
<label id="auth-POSTapi-type-of-recipesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-type-of-recipesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>category</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="category" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>school_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="school_id" data-endpoint="POSTapi-type-of-recipesall" data-component="body"  hidden>
<br>

</p>

</form>


## Show the form for creating a new resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/type-of-recipes" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type_of_recipes":[{"name":"distinctio","code":"sint","category":"quaerat","idSchool":9}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type_of_recipes": [
        {
            "name": "distinctio",
            "code": "sint",
            "category": "quaerat",
            "idSchool": 9
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
    'http://localhost/api/type-of-recipes',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type_of_recipes' => [
                [
                    'name' => 'distinctio',
                    'code' => 'sint',
                    'category' => 'quaerat',
                    'idSchool' => 9,
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
<div id="execution-results-POSTapi-type-of-recipes" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-type-of-recipes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-type-of-recipes"></code></pre>
</div>
<div id="execution-error-POSTapi-type-of-recipes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-type-of-recipes"></code></pre>
</div>
<form id="form-POSTapi-type-of-recipes" data-method="POST" data-path="api/type-of-recipes" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-type-of-recipes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/type-of-recipes</code></b>
</p>
<p>
<label id="auth-POSTapi-type-of-recipes" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-type-of-recipes" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>type_of_recipes</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>type_of_recipes[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_of_recipes.0.name" data-endpoint="POSTapi-type-of-recipes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_of_recipes[].code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type_of_recipes.0.code" data-endpoint="POSTapi-type-of-recipes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_of_recipes[].category</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_of_recipes.0.category" data-endpoint="POSTapi-type-of-recipes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_of_recipes[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type_of_recipes.0.idSchool" data-endpoint="POSTapi-type-of-recipes" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/type-of-recipes/non" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes/non"
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
    'http://localhost/api/type-of-recipes/non',
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
<div id="execution-results-GETapi-type-of-recipes--type_of_recipe-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-type-of-recipes--type_of_recipe-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-type-of-recipes--type_of_recipe-"></code></pre>
</div>
<div id="execution-error-GETapi-type-of-recipes--type_of_recipe-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-type-of-recipes--type_of_recipe-"></code></pre>
</div>
<form id="form-GETapi-type-of-recipes--type_of_recipe-" data-method="GET" data-path="api/type-of-recipes/{type_of_recipe}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-type-of-recipes--type_of_recipe-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/type-of-recipes/{type_of_recipe}</code></b>
</p>
<p>
<label id="auth-GETapi-type-of-recipes--type_of_recipe-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-type-of-recipes--type_of_recipe-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>type_of_recipe</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_of_recipe" data-endpoint="GETapi-type-of-recipes--type_of_recipe-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/type-of-recipes/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"iste","code":"laudantium","category":"autem","idSchool":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "iste",
    "code": "laudantium",
    "category": "autem",
    "idSchool": 1
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
    'http://localhost/api/type-of-recipes/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'iste',
            'code' => 'laudantium',
            'category' => 'autem',
            'idSchool' => 1,
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
<div id="execution-results-PUTapi-type-of-recipes--type_of_recipe-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-type-of-recipes--type_of_recipe-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-type-of-recipes--type_of_recipe-"></code></pre>
</div>
<div id="execution-error-PUTapi-type-of-recipes--type_of_recipe-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-type-of-recipes--type_of_recipe-"></code></pre>
</div>
<form id="form-PUTapi-type-of-recipes--type_of_recipe-" data-method="PUT" data-path="api/type-of-recipes/{type_of_recipe}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-type-of-recipes--type_of_recipe-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/type-of-recipes/{type_of_recipe}</code></b>
</p>
<p>
<label id="auth-PUTapi-type-of-recipes--type_of_recipe-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>type_of_recipe</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_of_recipe" data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="code" data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>category</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="category" data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-type-of-recipes--type_of_recipe-" data-component="body"  hidden>
<br>

</p>

</form>


## Fonction pour le multiple archivage des type_of_recipes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/type-of-recipes/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[11,18]}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        11,
        18
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
    'http://localhost/api/type-of-recipes/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                11,
                18,
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
<div id="execution-results-POSTapi-type-of-recipes-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-type-of-recipes-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-type-of-recipes-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-type-of-recipes-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-type-of-recipes-trash"></code></pre>
</div>
<form id="form-POSTapi-type-of-recipes-trash" data-method="POST" data-path="api/type-of-recipes/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-type-of-recipes-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/type-of-recipes/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-type-of-recipes-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-type-of-recipes-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-type-of-recipes-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-type-of-recipes-trash" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de restauration multiples des type_of_recipes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/type-of-recipes/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[1,18]}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        1,
        18
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
    'http://localhost/api/type-of-recipes/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                1,
                18,
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
<div id="execution-results-POSTapi-type-of-recipes-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-type-of-recipes-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-type-of-recipes-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-type-of-recipes-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-type-of-recipes-restore"></code></pre>
</div>
<form id="form-POSTapi-type-of-recipes-restore" data-method="POST" data-path="api/type-of-recipes/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-type-of-recipes-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/type-of-recipes/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-type-of-recipes-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-type-of-recipes-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-type-of-recipes-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-type-of-recipes-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des type_of_recipes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/type-of-recipes/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[4,7]}'

```

```javascript
const url = new URL(
    "http://localhost/api/type-of-recipes/delete"
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
    'http://localhost/api/type-of-recipes/delete',
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
<div id="execution-results-POSTapi-type-of-recipes-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-type-of-recipes-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-type-of-recipes-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-type-of-recipes-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-type-of-recipes-delete"></code></pre>
</div>
<form id="form-POSTapi-type-of-recipes-delete" data-method="POST" data-path="api/type-of-recipes/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-type-of-recipes-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/type-of-recipes/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-type-of-recipes-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-type-of-recipes-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-type-of-recipes-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-type-of-recipes-delete" data-component="body" hidden>
<br>

</p>

</form>


## api/mtn-payments

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mtn-payments" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":4,"idSchool":9,"idSection":6,"amount":2,"payment_mode":"sint","phonePayeur":"animi","reference":"omnis","idPension":14,"idFee":7,"transport_user_id":2,"idLevel":19,"idClasse":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/mtn-payments"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 4,
    "idSchool": 9,
    "idSection": 6,
    "amount": 2,
    "payment_mode": "sint",
    "phonePayeur": "animi",
    "reference": "omnis",
    "idPension": 14,
    "idFee": 7,
    "transport_user_id": 2,
    "idLevel": 19,
    "idClasse": 8
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
    'http://localhost/api/mtn-payments',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 4,
            'idSchool' => 9,
            'idSection' => 6,
            'amount' => 2,
            'payment_mode' => 'sint',
            'phonePayeur' => 'animi',
            'reference' => 'omnis',
            'idPension' => 14,
            'idFee' => 7,
            'transport_user_id' => 2,
            'idLevel' => 19,
            'idClasse' => 8,
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
<div id="execution-results-POSTapi-mtn-payments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mtn-payments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mtn-payments"></code></pre>
</div>
<div id="execution-error-POSTapi-mtn-payments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mtn-payments"></code></pre>
</div>
<form id="form-POSTapi-mtn-payments" data-method="POST" data-path="api/mtn-payments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mtn-payments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mtn-payments</code></b>
</p>
<p>
<label id="auth-POSTapi-mtn-payments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mtn-payments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="amount" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>phonePayeur</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phonePayeur" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-mtn-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-mtn-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-mtn-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>transport_user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="transport_user_id" data-endpoint="POSTapi-mtn-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-mtn-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-mtn-payments" data-component="body"  hidden>
<br>

</p>

</form>


## api/mtn-payments/hook

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mtn-payments/hook" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/mtn-payments/hook"
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
    'http://localhost/api/mtn-payments/hook',
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
<div id="execution-results-POSTapi-mtn-payments-hook" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mtn-payments-hook"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mtn-payments-hook"></code></pre>
</div>
<div id="execution-error-POSTapi-mtn-payments-hook" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mtn-payments-hook"></code></pre>
</div>
<form id="form-POSTapi-mtn-payments-hook" data-method="POST" data-path="api/mtn-payments/hook" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mtn-payments-hook', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mtn-payments/hook</code></b>
</p>
<p>
<label id="auth-POSTapi-mtn-payments-hook" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mtn-payments-hook" data-component="header"></label>
</p>
</form>


## api/mtn-payments/{transaction}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/mtn-payments/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/mtn-payments/et"
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
    'http://localhost/api/mtn-payments/et',
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
<div id="execution-results-GETapi-mtn-payments--transaction-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-mtn-payments--transaction-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-mtn-payments--transaction-"></code></pre>
</div>
<div id="execution-error-GETapi-mtn-payments--transaction-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-mtn-payments--transaction-"></code></pre>
</div>
<form id="form-GETapi-mtn-payments--transaction-" data-method="GET" data-path="api/mtn-payments/{transaction}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-mtn-payments--transaction-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/mtn-payments/{transaction}</code></b>
</p>
<p>
<label id="auth-GETapi-mtn-payments--transaction-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-mtn-payments--transaction-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>transaction</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="transaction" data-endpoint="GETapi-mtn-payments--transaction-" data-component="url" required  hidden>
<br>

</p>
</form>


## api/mtn-payments/statistics

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mtn-payments/statistics" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":10,"idSection":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/mtn-payments/statistics"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 10,
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
    'http://localhost/api/mtn-payments/statistics',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 10,
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
<div id="execution-results-POSTapi-mtn-payments-statistics" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mtn-payments-statistics"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mtn-payments-statistics"></code></pre>
</div>
<div id="execution-error-POSTapi-mtn-payments-statistics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mtn-payments-statistics"></code></pre>
</div>
<form id="form-POSTapi-mtn-payments-statistics" data-method="POST" data-path="api/mtn-payments/statistics" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mtn-payments-statistics', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mtn-payments/statistics</code></b>
</p>
<p>
<label id="auth-POSTapi-mtn-payments-statistics" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mtn-payments-statistics" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-mtn-payments-statistics" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-mtn-payments-statistics" data-component="body"  hidden>
<br>

</p>

</form>



