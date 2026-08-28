# QR Code


## Enregistrer la présence par scan de QR Code

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/qrcodepresence" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"secret":"similique","route":"blanditiis","scanPerCourse":false,"type":"laborum","idCourse":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/qrcodepresence"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "secret": "similique",
    "route": "blanditiis",
    "scanPerCourse": false,
    "type": "laborum",
    "idCourse": 20
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
    'http://localhost/api/qrcodepresence',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'secret' => 'similique',
            'route' => 'blanditiis',
            'scanPerCourse' => false,
            'type' => 'laborum',
            'idCourse' => 20,
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
<div id="execution-results-POSTapi-qrcodepresence" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-qrcodepresence"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-qrcodepresence"></code></pre>
</div>
<div id="execution-error-POSTapi-qrcodepresence" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-qrcodepresence"></code></pre>
</div>
<form id="form-POSTapi-qrcodepresence" data-method="POST" data-path="api/qrcodepresence" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-qrcodepresence', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/qrcodepresence</code></b>
</p>
<p>
<label id="auth-POSTapi-qrcodepresence" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-qrcodepresence" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>secret</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="secret" data-endpoint="POSTapi-qrcodepresence" data-component="body" required  hidden>
<br>
Hash dans le QR Code
</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-qrcodepresence" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scanPerCourse</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-qrcodepresence" hidden><input type="radio" name="scanPerCourse" value="true" data-endpoint="POSTapi-qrcodepresence" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-qrcodepresence" hidden><input type="radio" name="scanPerCourse" value="false" data-endpoint="POSTapi-qrcodepresence" data-component="body" required ><code>false</code></label>
<br>
Est-ce que la personne doit scanner à chaque cours ou pas ?
</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-qrcodepresence" data-component="body" required  hidden>
<br>
teacher/staff
</p>
<p>
<b><code>idCourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCourse" data-endpoint="POSTapi-qrcodepresence" data-component="body"  hidden>
<br>
required_if:scanPerCourse,true
</p>

</form>


## Générer un hash pour le QR Code

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/generate-qr-code" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"illum","route":"nobis","idClasse":18}'

```

```javascript
const url = new URL(
    "http://localhost/api/generate-qr-code"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "illum",
    "route": "nobis",
    "idClasse": 18
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
    'http://localhost/api/generate-qr-code',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'illum',
            'route' => 'nobis',
            'idClasse' => 18,
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
<div id="execution-results-POSTapi-generate-qr-code" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generate-qr-code"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generate-qr-code"></code></pre>
</div>
<div id="execution-error-POSTapi-generate-qr-code" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generate-qr-code"></code></pre>
</div>
<form id="form-POSTapi-generate-qr-code" data-method="POST" data-path="api/generate-qr-code" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generate-qr-code', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generate-qr-code</code></b>
</p>
<p>
<label id="auth-POSTapi-generate-qr-code" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generate-qr-code" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-generate-qr-code" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-generate-qr-code" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-generate-qr-code" data-component="body"  hidden>
<br>
ID de la classe pour laquelle on génère le hash du QR Code
</p>

</form>



