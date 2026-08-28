# Bulletins Primaire


## Générer bulletin(s) primaire séquence

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-primaire-sequence" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":11,"route":"similique","idUser":20,"idAssessmentType":20,"idOptionLevel":20,"forSolvables":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-primaire-sequence"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 11,
    "route": "similique",
    "idUser": 20,
    "idAssessmentType": 20,
    "idOptionLevel": 20,
    "forSolvables": false
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
    'http://localhost/api/generer-bulletin-primaire-sequence',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 11,
            'route' => 'similique',
            'idUser' => 20,
            'idAssessmentType' => 20,
            'idOptionLevel' => 20,
            'forSolvables' => false,
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
<div id="execution-results-POSTapi-generer-bulletin-primaire-sequence" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-primaire-sequence"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-primaire-sequence"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-primaire-sequence" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-primaire-sequence"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-primaire-sequence" data-method="POST" data-path="api/generer-bulletin-primaire-sequence" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-primaire-sequence', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-primaire-sequence</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-primaire-sequence" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>forSolvables</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-generer-bulletin-primaire-sequence" hidden><input type="radio" name="forSolvables" value="true" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-generer-bulletin-primaire-sequence" hidden><input type="radio" name="forSolvables" value="false" data-endpoint="POSTapi-generer-bulletin-primaire-sequence" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Générer bulletin(s) trimestre du Primaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-primaire-trimestre" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":1,"idAssessmentType":5,"idTrimestre":13,"route":"tenetur","idUser":11,"idOptionLevel":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-primaire-trimestre"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 1,
    "idAssessmentType": 5,
    "idTrimestre": 13,
    "route": "tenetur",
    "idUser": 11,
    "idOptionLevel": 4
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
    'http://localhost/api/generer-bulletin-primaire-trimestre',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 1,
            'idAssessmentType' => 5,
            'idTrimestre' => 13,
            'route' => 'tenetur',
            'idUser' => 11,
            'idOptionLevel' => 4,
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
<div id="execution-results-POSTapi-generer-bulletin-primaire-trimestre" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-primaire-trimestre"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-primaire-trimestre"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-primaire-trimestre" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-primaire-trimestre"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-primaire-trimestre" data-method="POST" data-path="api/generer-bulletin-primaire-trimestre" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-primaire-trimestre', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-primaire-trimestre</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-primaire-trimestre" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre" data-component="body"  hidden>
<br>

</p>

</form>


## Générer bulletin(s) primaire séquence/trimestre/annuel

<small class="badge badge-darkred">requires authentication</small>

NOUVELLE STRUCTURE

> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-primaire-trimestre-new" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":8,"idAssessmentType":6,"idTrimestre":16,"route":"dolore","idUser":9,"idOptionLevel":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-primaire-trimestre-new"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 8,
    "idAssessmentType": 6,
    "idTrimestre": 16,
    "route": "dolore",
    "idUser": 9,
    "idOptionLevel": 4
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
    'http://localhost/api/generer-bulletin-primaire-trimestre-new',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 8,
            'idAssessmentType' => 6,
            'idTrimestre' => 16,
            'route' => 'dolore',
            'idUser' => 9,
            'idOptionLevel' => 4,
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
<div id="execution-results-POSTapi-generer-bulletin-primaire-trimestre-new" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-primaire-trimestre-new"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-primaire-trimestre-new"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-primaire-trimestre-new" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-primaire-trimestre-new"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-primaire-trimestre-new" data-method="POST" data-path="api/generer-bulletin-primaire-trimestre-new" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-primaire-trimestre-new', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-primaire-trimestre-new</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-primaire-trimestre-new" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-primaire-trimestre-new" data-component="body"  hidden>
<br>

</p>

</form>


## api/afficher-notes-maternelle-primaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/afficher-notes-maternelle-primaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":7,"idOptionLevel":9}'

```

```javascript
const url = new URL(
    "http://localhost/api/afficher-notes-maternelle-primaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 7,
    "idOptionLevel": 9
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
    'http://localhost/api/afficher-notes-maternelle-primaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 7,
            'idOptionLevel' => 9,
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
<div id="execution-results-POSTapi-afficher-notes-maternelle-primaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-afficher-notes-maternelle-primaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-afficher-notes-maternelle-primaire"></code></pre>
</div>
<div id="execution-error-POSTapi-afficher-notes-maternelle-primaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-afficher-notes-maternelle-primaire"></code></pre>
</div>
<form id="form-POSTapi-afficher-notes-maternelle-primaire" data-method="POST" data-path="api/afficher-notes-maternelle-primaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-afficher-notes-maternelle-primaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/afficher-notes-maternelle-primaire</code></b>
</p>
<p>
<label id="auth-POSTapi-afficher-notes-maternelle-primaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-afficher-notes-maternelle-primaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-afficher-notes-maternelle-primaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-afficher-notes-maternelle-primaire" data-component="body"  hidden>
<br>

</p>

</form>


## api/generer-bulletin-maternelle-primaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-maternelle-primaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"styleMaternelle":false,"idClasse":18,"idAssessmentType":2,"idTrimestre":8,"route":"aperiam","idUser":12,"idOptionLevel":4,"idAcademicYear":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-maternelle-primaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "styleMaternelle": false,
    "idClasse": 18,
    "idAssessmentType": 2,
    "idTrimestre": 8,
    "route": "aperiam",
    "idUser": 12,
    "idOptionLevel": 4,
    "idAcademicYear": 8
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
    'http://localhost/api/generer-bulletin-maternelle-primaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'styleMaternelle' => false,
            'idClasse' => 18,
            'idAssessmentType' => 2,
            'idTrimestre' => 8,
            'route' => 'aperiam',
            'idUser' => 12,
            'idOptionLevel' => 4,
            'idAcademicYear' => 8,
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
<div id="execution-results-POSTapi-generer-bulletin-maternelle-primaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-maternelle-primaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-maternelle-primaire"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-maternelle-primaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-maternelle-primaire"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-maternelle-primaire" data-method="POST" data-path="api/generer-bulletin-maternelle-primaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-maternelle-primaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-maternelle-primaire</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-maternelle-primaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>styleMaternelle</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" hidden><input type="radio" name="styleMaternelle" value="true" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" hidden><input type="radio" name="styleMaternelle" value="false" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-generer-bulletin-maternelle-primaire" data-component="body"  hidden>
<br>

</p>

</form>


## api/generer-bulletin-test

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-test" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"styleMaternelle":false,"idClasse":13,"idAssessmentType":4,"idTrimestre":18,"route":"quia","idUser":18,"idOptionLevel":11,"idAcademicYear":16}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-test"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "styleMaternelle": false,
    "idClasse": 13,
    "idAssessmentType": 4,
    "idTrimestre": 18,
    "route": "quia",
    "idUser": 18,
    "idOptionLevel": 11,
    "idAcademicYear": 16
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
    'http://localhost/api/generer-bulletin-test',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'styleMaternelle' => false,
            'idClasse' => 13,
            'idAssessmentType' => 4,
            'idTrimestre' => 18,
            'route' => 'quia',
            'idUser' => 18,
            'idOptionLevel' => 11,
            'idAcademicYear' => 16,
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
<div id="execution-results-POSTapi-generer-bulletin-test" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-test"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-test"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-test" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-test"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-test" data-method="POST" data-path="api/generer-bulletin-test" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-test', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-test</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-test" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-test" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>styleMaternelle</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-generer-bulletin-test" hidden><input type="radio" name="styleMaternelle" value="true" data-endpoint="POSTapi-generer-bulletin-test" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-generer-bulletin-test" hidden><input type="radio" name="styleMaternelle" value="false" data-endpoint="POSTapi-generer-bulletin-test" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-test" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-generer-bulletin-test" data-component="body"  hidden>
<br>

</p>

</form>


## api/statistiques-annuelles-maternelle-primaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/statistiques-annuelles-maternelle-primaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/statistiques-annuelles-maternelle-primaire"
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
    'http://localhost/api/statistiques-annuelles-maternelle-primaire',
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
<div id="execution-results-POSTapi-statistiques-annuelles-maternelle-primaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-statistiques-annuelles-maternelle-primaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-statistiques-annuelles-maternelle-primaire"></code></pre>
</div>
<div id="execution-error-POSTapi-statistiques-annuelles-maternelle-primaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-statistiques-annuelles-maternelle-primaire"></code></pre>
</div>
<form id="form-POSTapi-statistiques-annuelles-maternelle-primaire" data-method="POST" data-path="api/statistiques-annuelles-maternelle-primaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-statistiques-annuelles-maternelle-primaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/statistiques-annuelles-maternelle-primaire</code></b>
</p>
<p>
<label id="auth-POSTapi-statistiques-annuelles-maternelle-primaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-statistiques-annuelles-maternelle-primaire" data-component="header"></label>
</p>
</form>


## Générer PV séquence du primaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/pv-primaire-sequence" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":18,"idAssessmentType":20,"idOptionLevel":3,"sortUsers":"merit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/pv-primaire-sequence"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 18,
    "idAssessmentType": 20,
    "idOptionLevel": 3,
    "sortUsers": "merit"
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
    'http://localhost/api/documents/pv-primaire-sequence',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 18,
            'idAssessmentType' => 20,
            'idOptionLevel' => 3,
            'sortUsers' => 'merit',
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
<div id="execution-results-POSTapi-documents-pv-primaire-sequence" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-pv-primaire-sequence"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-pv-primaire-sequence"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-pv-primaire-sequence" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-pv-primaire-sequence"></code></pre>
</div>
<form id="form-POSTapi-documents-pv-primaire-sequence" data-method="POST" data-path="api/documents/pv-primaire-sequence" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-pv-primaire-sequence', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/pv-primaire-sequence</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-pv-primaire-sequence" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-pv-primaire-sequence" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-pv-primaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-documents-pv-primaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-documents-pv-primaire-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>sortUsers</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="sortUsers" data-endpoint="POSTapi-documents-pv-primaire-sequence" data-component="body"  hidden>
<br>
The value must be one of <code>merit</code> or <code>alphabetical</code>.
</p>

</form>


## PV Primaire Séquence / Trimestre
Abiscom :
{ &quot;idClasse&quot;: 6, &quot;idTrimestre&quot;: 1, // &quot;idAssessmentType&quot;: 1, // &quot;idUser&quot;: 1516, &quot;sortUsers&quot;: &quot;merit&quot;, &quot;route&quot;: &quot;abiscom&quot;, &quot;lang&quot;: &quot;en&quot;}

<small class="badge badge-darkred">requires authentication</small>

Juniors :

> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/pv-primaire-trimestre-sequentiel" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":4,"idTrimestre":5,"idAssessmentType":14,"idUser":14,"idOptionLevel":11,"styleMaternelle":false,"sortUsers":"merit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/pv-primaire-trimestre-sequentiel"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 4,
    "idTrimestre": 5,
    "idAssessmentType": 14,
    "idUser": 14,
    "idOptionLevel": 11,
    "styleMaternelle": false,
    "sortUsers": "merit"
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
    'http://localhost/api/documents/pv-primaire-trimestre-sequentiel',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 4,
            'idTrimestre' => 5,
            'idAssessmentType' => 14,
            'idUser' => 14,
            'idOptionLevel' => 11,
            'styleMaternelle' => false,
            'sortUsers' => 'merit',
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
<div id="execution-results-POSTapi-documents-pv-primaire-trimestre-sequentiel" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-pv-primaire-trimestre-sequentiel"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-pv-primaire-trimestre-sequentiel"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-pv-primaire-trimestre-sequentiel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-pv-primaire-trimestre-sequentiel"></code></pre>
</div>
<form id="form-POSTapi-documents-pv-primaire-trimestre-sequentiel" data-method="POST" data-path="api/documents/pv-primaire-trimestre-sequentiel" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-pv-primaire-trimestre-sequentiel', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/pv-primaire-trimestre-sequentiel</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-pv-primaire-trimestre-sequentiel" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>styleMaternelle</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" hidden><input type="radio" name="styleMaternelle" value="true" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" hidden><input type="radio" name="styleMaternelle" value="false" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>sortUsers</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="sortUsers" data-endpoint="POSTapi-documents-pv-primaire-trimestre-sequentiel" data-component="body"  hidden>
<br>
The value must be one of <code>merit</code> or <code>alphabetical</code>.
</p>

</form>



