# Bulletins Secondaire


## Générer bulletin séquence du secondaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-secondaire-sequence" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":8,"idAssessmentType":15,"idUser":3,"idOptionLevel":14}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-secondaire-sequence"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 8,
    "idAssessmentType": 15,
    "idUser": 3,
    "idOptionLevel": 14
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
    'http://localhost/api/generer-bulletin-secondaire-sequence',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 8,
            'idAssessmentType' => 15,
            'idUser' => 3,
            'idOptionLevel' => 14,
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
<div id="execution-results-POSTapi-generer-bulletin-secondaire-sequence" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-secondaire-sequence"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-secondaire-sequence"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-secondaire-sequence" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-secondaire-sequence"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-secondaire-sequence" data-method="POST" data-path="api/generer-bulletin-secondaire-sequence" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-secondaire-sequence', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-secondaire-sequence</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-secondaire-sequence" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-secondaire-sequence" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-secondaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-secondaire-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-secondaire-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-secondaire-sequence" data-component="body"  hidden>
<br>

</p>

</form>


## api/afficher-notes-secondaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/afficher-notes-secondaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":3,"idOptionLevel":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/afficher-notes-secondaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 3,
    "idOptionLevel": 13
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
    'http://localhost/api/afficher-notes-secondaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 3,
            'idOptionLevel' => 13,
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
<div id="execution-results-POSTapi-afficher-notes-secondaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-afficher-notes-secondaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-afficher-notes-secondaire"></code></pre>
</div>
<div id="execution-error-POSTapi-afficher-notes-secondaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-afficher-notes-secondaire"></code></pre>
</div>
<form id="form-POSTapi-afficher-notes-secondaire" data-method="POST" data-path="api/afficher-notes-secondaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-afficher-notes-secondaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/afficher-notes-secondaire</code></b>
</p>
<p>
<label id="auth-POSTapi-afficher-notes-secondaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-afficher-notes-secondaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-afficher-notes-secondaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-afficher-notes-secondaire" data-component="body"  hidden>
<br>

</p>

</form>


## api/generer-bulletin-secondaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-secondaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":16,"idSemestre":14,"idTrimestre":17,"idAssessmentType":14,"idUser":7,"idOptionLevel":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-secondaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 16,
    "idSemestre": 14,
    "idTrimestre": 17,
    "idAssessmentType": 14,
    "idUser": 7,
    "idOptionLevel": 20
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
    'http://localhost/api/generer-bulletin-secondaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 16,
            'idSemestre' => 14,
            'idTrimestre' => 17,
            'idAssessmentType' => 14,
            'idUser' => 7,
            'idOptionLevel' => 20,
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
<div id="execution-results-POSTapi-generer-bulletin-secondaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-secondaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-secondaire"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-secondaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-secondaire"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-secondaire" data-method="POST" data-path="api/generer-bulletin-secondaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-secondaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-secondaire</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-secondaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSemestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSemestre" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-secondaire" data-component="body"  hidden>
<br>

</p>

</form>


## api/documents/pv-secondaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/documents/pv-secondaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":3,"idSemestre":19,"idTrimestre":3,"idAssessmentType":20,"idUser":15,"idOptionLevel":15}'

```

```javascript
const url = new URL(
    "http://localhost/api/documents/pv-secondaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 3,
    "idSemestre": 19,
    "idTrimestre": 3,
    "idAssessmentType": 20,
    "idUser": 15,
    "idOptionLevel": 15
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
    'http://localhost/api/documents/pv-secondaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 3,
            'idSemestre' => 19,
            'idTrimestre' => 3,
            'idAssessmentType' => 20,
            'idUser' => 15,
            'idOptionLevel' => 15,
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
<div id="execution-results-POSTapi-documents-pv-secondaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-documents-pv-secondaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documents-pv-secondaire"></code></pre>
</div>
<div id="execution-error-POSTapi-documents-pv-secondaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documents-pv-secondaire"></code></pre>
</div>
<form id="form-POSTapi-documents-pv-secondaire" data-method="POST" data-path="api/documents/pv-secondaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-documents-pv-secondaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/documents/pv-secondaire</code></b>
</p>
<p>
<label id="auth-POSTapi-documents-pv-secondaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-documents-pv-secondaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSemestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSemestre" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-documents-pv-secondaire" data-component="body"  hidden>
<br>

</p>

</form>



