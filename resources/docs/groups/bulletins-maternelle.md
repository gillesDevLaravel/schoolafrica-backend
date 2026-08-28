# Bulletins Maternelle


## Générer buleltin(s) séquence de la maternelle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-maternelle-sequence" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":3,"route":"nihil","idUser":13,"idAssessmentType":9,"idOptionLevel":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-maternelle-sequence"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 3,
    "route": "nihil",
    "idUser": 13,
    "idAssessmentType": 9,
    "idOptionLevel": 3
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
    'http://localhost/api/generer-bulletin-maternelle-sequence',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 3,
            'route' => 'nihil',
            'idUser' => 13,
            'idAssessmentType' => 9,
            'idOptionLevel' => 3,
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
<div id="execution-results-POSTapi-generer-bulletin-maternelle-sequence" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-maternelle-sequence"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-maternelle-sequence"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-maternelle-sequence" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-maternelle-sequence"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-maternelle-sequence" data-method="POST" data-path="api/generer-bulletin-maternelle-sequence" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-maternelle-sequence', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-maternelle-sequence</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-maternelle-sequence" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-maternelle-sequence" data-component="body"  hidden>
<br>

</p>

</form>


## api/generer-bulletin-maternelle-trimestre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generer-bulletin-maternelle-trimestre" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":20,"idAssessmentType":4,"idTrimestre":8,"route":"tenetur","idUser":20,"idOptionLevel":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/generer-bulletin-maternelle-trimestre"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 20,
    "idAssessmentType": 4,
    "idTrimestre": 8,
    "route": "tenetur",
    "idUser": 20,
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
    'http://localhost/api/generer-bulletin-maternelle-trimestre',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 20,
            'idAssessmentType' => 4,
            'idTrimestre' => 8,
            'route' => 'tenetur',
            'idUser' => 20,
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
<div id="execution-results-POSTapi-generer-bulletin-maternelle-trimestre" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generer-bulletin-maternelle-trimestre"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generer-bulletin-maternelle-trimestre"></code></pre>
</div>
<div id="execution-error-POSTapi-generer-bulletin-maternelle-trimestre" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generer-bulletin-maternelle-trimestre"></code></pre>
</div>
<form id="form-POSTapi-generer-bulletin-maternelle-trimestre" data-method="POST" data-path="api/generer-bulletin-maternelle-trimestre" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generer-bulletin-maternelle-trimestre', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generer-bulletin-maternelle-trimestre</code></b>
</p>
<p>
<label id="auth-POSTapi-generer-bulletin-maternelle-trimestre" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-generer-bulletin-maternelle-trimestre" data-component="body"  hidden>
<br>

</p>

</form>



