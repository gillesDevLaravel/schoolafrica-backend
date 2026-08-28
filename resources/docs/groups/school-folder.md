# School Folder


## List des dossiers scolaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schoolFoldersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":16,"idSection":16,"idStudent":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/schoolFoldersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 16,
    "idSection": 16,
    "idStudent": 4
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
    'http://localhost/api/schoolFoldersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 16,
            'idSection' => 16,
            'idStudent' => 4,
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
<div id="execution-results-POSTapi-schoolFoldersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schoolFoldersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schoolFoldersall"></code></pre>
</div>
<div id="execution-error-POSTapi-schoolFoldersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schoolFoldersall"></code></pre>
</div>
<form id="form-POSTapi-schoolFoldersall" data-method="POST" data-path="api/schoolFoldersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schoolFoldersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schoolFoldersall</code></b>
</p>
<p>
<label id="auth-POSTapi-schoolFoldersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schoolFoldersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-schoolFoldersall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-schoolFoldersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-schoolFoldersall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/schoolFolders/quo" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolFolders/quo"
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
    'http://localhost/api/schoolFolders/quo',
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
<div id="execution-results-GETapi-schoolFolders--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-schoolFolders--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-schoolFolders--id-"></code></pre>
</div>
<div id="execution-error-GETapi-schoolFolders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-schoolFolders--id-"></code></pre>
</div>
<form id="form-GETapi-schoolFolders--id-" data-method="GET" data-path="api/schoolFolders/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-schoolFolders--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/schoolFolders/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-schoolFolders--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-schoolFolders--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-schoolFolders--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un dossier scolaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schoolFolders" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"voluptatem","idSection":"laborum","idStudent":"accusantium","medicalCertificate":"quia","lastBulletin":"voluptatibus","lastDiploma":"non","birthCertificate":"voluptatem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schoolFolders"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "voluptatem",
    "idSection": "laborum",
    "idStudent": "accusantium",
    "medicalCertificate": "quia",
    "lastBulletin": "voluptatibus",
    "lastDiploma": "non",
    "birthCertificate": "voluptatem"
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
    'http://localhost/api/schoolFolders',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'voluptatem',
            'idSection' => 'laborum',
            'idStudent' => 'accusantium',
            'medicalCertificate' => 'quia',
            'lastBulletin' => 'voluptatibus',
            'lastDiploma' => 'non',
            'birthCertificate' => 'voluptatem',
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
<div id="execution-results-POSTapi-schoolFolders" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schoolFolders"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schoolFolders"></code></pre>
</div>
<div id="execution-error-POSTapi-schoolFolders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schoolFolders"></code></pre>
</div>
<form id="form-POSTapi-schoolFolders" data-method="POST" data-path="api/schoolFolders" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schoolFolders', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schoolFolders</code></b>
</p>
<p>
<label id="auth-POSTapi-schoolFolders" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schoolFolders" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>medicalCertificate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="medicalCertificate" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>lastBulletin</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastBulletin" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>lastDiploma</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastDiploma" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>birthCertificate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="birthCertificate" data-endpoint="POSTapi-schoolFolders" data-component="body" required  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/schoolFolders/natus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"eaque","idSection":"repellat","idStudent":"et","medicalCertificate":"dignissimos","lastBulletin":"ad","lastDiploma":"officiis","birthCertificate":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schoolFolders/natus"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "eaque",
    "idSection": "repellat",
    "idStudent": "et",
    "medicalCertificate": "dignissimos",
    "lastBulletin": "ad",
    "lastDiploma": "officiis",
    "birthCertificate": "ut"
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
    'http://localhost/api/schoolFolders/natus',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'eaque',
            'idSection' => 'repellat',
            'idStudent' => 'et',
            'medicalCertificate' => 'dignissimos',
            'lastBulletin' => 'ad',
            'lastDiploma' => 'officiis',
            'birthCertificate' => 'ut',
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
<div id="execution-results-PUTapi-schoolFolders--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-schoolFolders--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-schoolFolders--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-schoolFolders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-schoolFolders--id-"></code></pre>
</div>
<form id="form-PUTapi-schoolFolders--id-" data-method="PUT" data-path="api/schoolFolders/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-schoolFolders--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/schoolFolders/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-schoolFolders--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-schoolFolders--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-schoolFolders--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>medicalCertificate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="medicalCertificate" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>lastBulletin</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastBulletin" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>lastDiploma</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastDiploma" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>birthCertificate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="birthCertificate" data-endpoint="PUTapi-schoolFolders--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/schoolFolders/accusamus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolFolders/accusamus"
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
    'http://localhost/api/schoolFolders/accusamus',
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
<div id="execution-results-DELETEapi-schoolFolders--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-schoolFolders--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-schoolFolders--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-schoolFolders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-schoolFolders--id-"></code></pre>
</div>
<form id="form-DELETEapi-schoolFolders--id-" data-method="DELETE" data-path="api/schoolFolders/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-schoolFolders--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/schoolFolders/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-schoolFolders--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-schoolFolders--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-schoolFolders--id-" data-component="url" required  hidden>
<br>

</p>
</form>



