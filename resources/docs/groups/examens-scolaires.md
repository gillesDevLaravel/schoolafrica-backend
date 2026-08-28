# Examens scolaires

Gestion des examens d'école (schools_exams)

## Lister les examens

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools-examsall?filter_value=Math&idAssessment=2&idAssessmentType=1&pageItems=1&nbreItems=50" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"quam","idMatter":5,"idOptionLevel":6,"idAssessmentType":4,"pageItems":1,"nbreItems":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-examsall"
);

let params = {
    "filter_value": "Math",
    "idAssessment": "2",
    "idAssessmentType": "1",
    "pageItems": "1",
    "nbreItems": "50",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "quam",
    "idMatter": 5,
    "idOptionLevel": 6,
    "idAssessmentType": 4,
    "pageItems": 1,
    "nbreItems": 3
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
    'http://localhost/api/schools-examsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'query' => [
            'filter_value'=> 'Math',
            'idAssessment'=> '2',
            'idAssessmentType'=> '1',
            'pageItems'=> '1',
            'nbreItems'=> '50',
        ],
        'json' => [
            'filter_value' => 'quam',
            'idMatter' => 5,
            'idOptionLevel' => 6,
            'idAssessmentType' => 4,
            'pageItems' => 1,
            'nbreItems' => 3,
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
<div id="execution-results-POSTapi-schools-examsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools-examsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools-examsall"></code></pre>
</div>
<div id="execution-error-POSTapi-schools-examsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools-examsall"></code></pre>
</div>
<form id="form-POSTapi-schools-examsall" data-method="POST" data-path="api/schools-examsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools-examsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools-examsall</code></b>
</p>
<p>
<label id="auth-POSTapi-schools-examsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools-examsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-schools-examsall" data-component="query"  hidden>
<br>
Recherche par nom.
</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-schools-examsall" data-component="query"  hidden>
<br>
Filtrer par évaluation.
</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-schools-examsall" data-component="query"  hidden>
<br>
Filtrer par type d'évaluation.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-schools-examsall" data-component="query"  hidden>
<br>
Numéro de page.
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-schools-examsall" data-component="query"  hidden>
<br>
Nombre par page.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-schools-examsall" data-component="body"  hidden>
<br>

</p>

</form>


## Créer des examens (création en masse)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools-exams" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"exams":"molestiae"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "exams": "molestiae"
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
    'http://localhost/api/schools-exams',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'exams' => 'molestiae',
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
<div id="execution-results-POSTapi-schools-exams" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools-exams"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools-exams"></code></pre>
</div>
<div id="execution-error-POSTapi-schools-exams" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools-exams"></code></pre>
</div>
<form id="form-POSTapi-schools-exams" data-method="POST" data-path="api/schools-exams" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools-exams', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools-exams</code></b>
</p>
<p>
<label id="auth-POSTapi-schools-exams" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools-exams" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>exams</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Tableau des examens à créer.
</summary>
<br>
<p>
<b><code>exams[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exams.0.description" data-endpoint="POSTapi-schools-exams" data-component="body"  hidden>
<br>
Description de l'examen.
</p>
<p>
<b><code>exams[].answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exams.0.answer" data-endpoint="POSTapi-schools-exams" data-component="body"  hidden>
<br>
Réponse à l'examen.
</p>
<p>
<b><code>exams[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="exams.0.name" data-endpoint="POSTapi-schools-exams" data-component="body" required  hidden>
<br>
Nom de l'examen.
</p>
<p>
<b><code>exams[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="exams.0.image" data-endpoint="POSTapi-schools-exams" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exams[].idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="exams.0.idOptionLevel" data-endpoint="POSTapi-schools-exams" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>exams[].idMatter</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="exams.0.idMatter" data-endpoint="POSTapi-schools-exams" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>exams[].idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="exams.0.idAssessmentType" data-endpoint="POSTapi-schools-exams" data-component="body" required  hidden>
<br>
Type d'évaluation.
</p>
<p>
<b><code>exams[].classes</code></b>&nbsp;&nbsp;<small>array</small>     <i>optional</i> &nbsp;
<input type="text" name="exams.0.classes" data-endpoint="POSTapi-schools-exams" data-component="body"  hidden>
<br>
Tableau des IDs des classes.
</p>
<p>
<b><code>exams[].idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="exams.0.idAssessment" data-endpoint="POSTapi-schools-exams" data-component="body" required  hidden>
<br>
Identifiant de l'évaluation.
</p>
</details>
</p>

</form>


## Afficher un examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/schools-exams/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams/12"
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
    'http://localhost/api/schools-exams/12',
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
<div id="execution-results-GETapi-schools-exams--school_exam-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-schools-exams--school_exam-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-schools-exams--school_exam-"></code></pre>
</div>
<div id="execution-error-GETapi-schools-exams--school_exam-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-schools-exams--school_exam-"></code></pre>
</div>
<form id="form-GETapi-schools-exams--school_exam-" data-method="GET" data-path="api/schools-exams/{school_exam}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-schools-exams--school_exam-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/schools-exams/{school_exam}</code></b>
</p>
<p>
<label id="auth-GETapi-schools-exams--school_exam-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-schools-exams--school_exam-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>school_exam</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="school_exam" data-endpoint="GETapi-schools-exams--school_exam-" data-component="url" required  hidden>
<br>
ID de l'examen.
</p>
</form>


## Mettre à jour un examen

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/schools-exams/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Examen final","image":"placeat","description":"Examen de fin d'ann\u00e9e","answer":"R\u00e9ponse type","idOptionLevel":18,"idMatter":20,"idAssessmentType":2,"classes":"[1,2,3]","idAssessment":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams/12"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Examen final",
    "image": "placeat",
    "description": "Examen de fin d'ann\u00e9e",
    "answer": "R\u00e9ponse type",
    "idOptionLevel": 18,
    "idMatter": 20,
    "idAssessmentType": 2,
    "classes": "[1,2,3]",
    "idAssessment": 3
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
    'http://localhost/api/schools-exams/12',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'Examen final',
            'image' => 'placeat',
            'description' => 'Examen de fin d\'année',
            'answer' => 'Réponse type',
            'idOptionLevel' => 18,
            'idMatter' => 20,
            'idAssessmentType' => 2,
            'classes' => '[1,2,3]',
            'idAssessment' => 3,
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
<div id="execution-results-PUTapi-schools-exams--school_exam-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-schools-exams--school_exam-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-schools-exams--school_exam-"></code></pre>
</div>
<div id="execution-error-PUTapi-schools-exams--school_exam-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-schools-exams--school_exam-"></code></pre>
</div>
<form id="form-PUTapi-schools-exams--school_exam-" data-method="PUT" data-path="api/schools-exams/{school_exam}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-schools-exams--school_exam-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/schools-exams/{school_exam}</code></b>
</p>
<p>
<label id="auth-PUTapi-schools-exams--school_exam-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-schools-exams--school_exam-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>school_exam</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="school_exam" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="url" required  hidden>
<br>
ID de l'examen.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Nom de l'examen.
</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Description de l'examen.
</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="answer" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Réponse à l'examen.
</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Type d'évaluation.
</p>
<p>
<b><code>classes</code></b>&nbsp;&nbsp;<small>array</small>     <i>optional</i> &nbsp;
<input type="text" name="classes" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Tableau des IDs des classes.
</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="PUTapi-schools-exams--school_exam-" data-component="body"  hidden>
<br>
Identifiant de l'évaluation.
</p>

</form>


## Archiver des examens (soft delete)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools-exams/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
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
    'http://localhost/api/schools-exams/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
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
<div id="execution-results-POSTapi-schools-exams-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools-exams-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools-exams-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-schools-exams-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools-exams-trash"></code></pre>
</div>
<form id="form-POSTapi-schools-exams-trash" data-method="POST" data-path="api/schools-exams/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools-exams-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools-exams/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-schools-exams-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools-exams-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à archiver.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-schools-exams-trash" data-component="body"  hidden>
<br>
ID d'un examen existant.
</p>
</details>
</p>

</form>


## Restaurer des examens archivés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools-exams/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
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
    'http://localhost/api/schools-exams/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
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
<div id="execution-results-POSTapi-schools-exams-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools-exams-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools-exams-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-schools-exams-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools-exams-restore"></code></pre>
</div>
<form id="form-POSTapi-schools-exams-restore" data-method="POST" data-path="api/schools-exams/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools-exams-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools-exams/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-schools-exams-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools-exams-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à restaurer.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-schools-exams-restore" data-component="body"  hidden>
<br>
ID d'un examen existant.
</p>
</details>
</p>

</form>


## Supprimer définitivement des examens

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools-exams/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools-exams/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
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
    'http://localhost/api/schools-exams/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
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
<div id="execution-results-POSTapi-schools-exams-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools-exams-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools-exams-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-schools-exams-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools-exams-delete"></code></pre>
</div>
<form id="form-POSTapi-schools-exams-delete" data-method="POST" data-path="api/schools-exams/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools-exams-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools-exams/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-schools-exams-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools-exams-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à supprimer définitivement.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-schools-exams-delete" data-component="body"  hidden>
<br>
ID d'un examen existant.
</p>
</details>
</p>

</form>



