# Users


## api/user

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/user" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/user"
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
    'http://localhost/api/user',
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
<div id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-user"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"></code></pre>
</div>
<div id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user"></code></pre>
</div>
<form id="form-GETapi-user" data-method="GET" data-path="api/user" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/user</code></b>
</p>
<p>
<label id="auth-GETapi-user" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-user" data-component="header"></label>
</p>
</form>


## api/transfertdatauser

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transfertdatauser" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transfertdatauser"
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
    'http://localhost/api/transfertdatauser',
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
<div id="execution-results-POSTapi-transfertdatauser" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transfertdatauser"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transfertdatauser"></code></pre>
</div>
<div id="execution-error-POSTapi-transfertdatauser" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transfertdatauser"></code></pre>
</div>
<form id="form-POSTapi-transfertdatauser" data-method="POST" data-path="api/transfertdatauser" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transfertdatauser', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transfertdatauser</code></b>
</p>
<p>
<label id="auth-POSTapi-transfertdatauser" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transfertdatauser" data-component="header"></label>
</p>
</form>


## api/insolvableinscription

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/insolvableinscription" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/insolvableinscription"
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
    'http://localhost/api/insolvableinscription',
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
<div id="execution-results-POSTapi-insolvableinscription" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-insolvableinscription"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-insolvableinscription"></code></pre>
</div>
<div id="execution-error-POSTapi-insolvableinscription" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-insolvableinscription"></code></pre>
</div>
<form id="form-POSTapi-insolvableinscription" data-method="POST" data-path="api/insolvableinscription" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-insolvableinscription', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/insolvableinscription</code></b>
</p>
<p>
<label id="auth-POSTapi-insolvableinscription" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-insolvableinscription" data-component="header"></label>
</p>
</form>


## api/dashboardfounder

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/dashboardfounder" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"accusantium","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/dashboardfounder"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "accusantium",
    "idSection": {}
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
    'http://localhost/api/dashboardfounder',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'accusantium',
            'idSection' => [],
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
<div id="execution-results-POSTapi-dashboardfounder" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-dashboardfounder"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-dashboardfounder"></code></pre>
</div>
<div id="execution-error-POSTapi-dashboardfounder" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-dashboardfounder"></code></pre>
</div>
<form id="form-POSTapi-dashboardfounder" data-method="POST" data-path="api/dashboardfounder" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-dashboardfounder', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/dashboardfounder</code></b>
</p>
<p>
<label id="auth-POSTapi-dashboardfounder" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-dashboardfounder" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-dashboardfounder" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-dashboardfounder" data-component="body"  hidden>
<br>

</p>

</form>


## Affichage des détails de finance pour fondateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/financedetail" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":2,"idSection":16,"idLevel":3,"idClasse":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/financedetail"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 2,
    "idSection": 16,
    "idLevel": 3,
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
    'http://localhost/api/financedetail',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 2,
            'idSection' => 16,
            'idLevel' => 3,
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
<div id="execution-results-POSTapi-financedetail" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-financedetail"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-financedetail"></code></pre>
</div>
<div id="execution-error-POSTapi-financedetail" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-financedetail"></code></pre>
</div>
<form id="form-POSTapi-financedetail" data-method="POST" data-path="api/financedetail" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-financedetail', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/financedetail</code></b>
</p>
<p>
<label id="auth-POSTapi-financedetail" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-financedetail" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-financedetail" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-financedetail" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-financedetail" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-financedetail" data-component="body"  hidden>
<br>

</p>

</form>


## api/financedetailparclasse

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/financedetailparclasse" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":3,"idSection":7,"idLevel":2,"idClasse":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/financedetailparclasse"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 3,
    "idSection": 7,
    "idLevel": 2,
    "idClasse": 3
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
    'http://localhost/api/financedetailparclasse',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 3,
            'idSection' => 7,
            'idLevel' => 2,
            'idClasse' => 3,
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
<div id="execution-results-POSTapi-financedetailparclasse" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-financedetailparclasse"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-financedetailparclasse"></code></pre>
</div>
<div id="execution-error-POSTapi-financedetailparclasse" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-financedetailparclasse"></code></pre>
</div>
<form id="form-POSTapi-financedetailparclasse" data-method="POST" data-path="api/financedetailparclasse" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-financedetailparclasse', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/financedetailparclasse</code></b>
</p>
<p>
<label id="auth-POSTapi-financedetailparclasse" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-financedetailparclasse" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-financedetailparclasse" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-financedetailparclasse" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-financedetailparclasse" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-financedetailparclasse" data-component="body"  hidden>
<br>

</p>

</form>


## api/financedetailpartranche

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/financedetailpartranche" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"nameTranche":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/api/financedetailpartranche"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "nameTranche": "et"
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
    'http://localhost/api/financedetailpartranche',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'nameTranche' => 'et',
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
<div id="execution-results-POSTapi-financedetailpartranche" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-financedetailpartranche"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-financedetailpartranche"></code></pre>
</div>
<div id="execution-error-POSTapi-financedetailpartranche" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-financedetailpartranche"></code></pre>
</div>
<form id="form-POSTapi-financedetailpartranche" data-method="POST" data-path="api/financedetailpartranche" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-financedetailpartranche', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/financedetailpartranche</code></b>
</p>
<p>
<label id="auth-POSTapi-financedetailpartranche" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-financedetailpartranche" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>nameTranche</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="nameTranche" data-endpoint="POSTapi-financedetailpartranche" data-component="body" required  hidden>
<br>

</p>

</form>


## api/dashboardparent

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/dashboardparent" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":3,"idStudent":17,"idSchool":15,"idSection":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/dashboardparent"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 3,
    "idStudent": 17,
    "idSchool": 15,
    "idSection": 8
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
    'http://localhost/api/dashboardparent',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 3,
            'idStudent' => 17,
            'idSchool' => 15,
            'idSection' => 8,
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
<div id="execution-results-POSTapi-dashboardparent" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-dashboardparent"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-dashboardparent"></code></pre>
</div>
<div id="execution-error-POSTapi-dashboardparent" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-dashboardparent"></code></pre>
</div>
<form id="form-POSTapi-dashboardparent" data-method="POST" data-path="api/dashboardparent" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-dashboardparent', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/dashboardparent</code></b>
</p>
<p>
<label id="auth-POSTapi-dashboardparent" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-dashboardparent" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-dashboardparent" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-dashboardparent" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-dashboardparent" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-dashboardparent" data-component="body"  hidden>
<br>

</p>

</form>


## api/dashboardteacher

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/dashboardteacher" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClasse":4,"idTeacher":13,"idSchool":8,"idSection":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/dashboardteacher"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClasse": 4,
    "idTeacher": 13,
    "idSchool": 8,
    "idSection": 11
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
    'http://localhost/api/dashboardteacher',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClasse' => 4,
            'idTeacher' => 13,
            'idSchool' => 8,
            'idSection' => 11,
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
<div id="execution-results-POSTapi-dashboardteacher" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-dashboardteacher"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-dashboardteacher"></code></pre>
</div>
<div id="execution-error-POSTapi-dashboardteacher" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-dashboardteacher"></code></pre>
</div>
<form id="form-POSTapi-dashboardteacher" data-method="POST" data-path="api/dashboardteacher" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-dashboardteacher', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/dashboardteacher</code></b>
</p>
<p>
<label id="auth-POSTapi-dashboardteacher" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-dashboardteacher" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-dashboardteacher" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-dashboardteacher" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-dashboardteacher" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-dashboardteacher" data-component="body"  hidden>
<br>

</p>

</form>


## api/dashboardcomptable

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/dashboardcomptable" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"harum","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/dashboardcomptable"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "harum",
    "idSection": {}
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
    'http://localhost/api/dashboardcomptable',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'harum',
            'idSection' => [],
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
<div id="execution-results-POSTapi-dashboardcomptable" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-dashboardcomptable"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-dashboardcomptable"></code></pre>
</div>
<div id="execution-error-POSTapi-dashboardcomptable" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-dashboardcomptable"></code></pre>
</div>
<form id="form-POSTapi-dashboardcomptable" data-method="POST" data-path="api/dashboardcomptable" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-dashboardcomptable', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/dashboardcomptable</code></b>
</p>
<p>
<label id="auth-POSTapi-dashboardcomptable" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-dashboardcomptable" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-dashboardcomptable" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-dashboardcomptable" data-component="body"  hidden>
<br>

</p>

</form>


## api/omstat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/omstat" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/omstat"
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
    'http://localhost/api/omstat',
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
<div id="execution-results-POSTapi-omstat" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-omstat"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-omstat"></code></pre>
</div>
<div id="execution-error-POSTapi-omstat" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-omstat"></code></pre>
</div>
<form id="form-POSTapi-omstat" data-method="POST" data-path="api/omstat" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-omstat', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/omstat</code></b>
</p>
<p>
<label id="auth-POSTapi-omstat" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-omstat" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;un utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/users/aut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/aut"
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
    'http://localhost/api/users/aut',
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
<div id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"></code></pre>
</div>
<div id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-"></code></pre>
</div>
<form id="form-GETapi-users--id-" data-method="GET" data-path="api/users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users"
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
    'http://localhost/api/users',
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
<div id="execution-results-POSTapi-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users"></code></pre>
</div>
<div id="execution-error-POSTapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users"></code></pre>
</div>
<form id="form-POSTapi-users" data-method="POST" data-path="api/users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users</code></b>
</p>
<p>
<label id="auth-POSTapi-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users" data-component="header"></label>
</p>
</form>


## Archiver un utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/usersar/deserunt" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/usersar/deserunt"
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
    'http://localhost/api/usersar/deserunt',
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
<div id="execution-results-POSTapi-usersar--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-usersar--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-usersar--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-usersar--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-usersar--id-"></code></pre>
</div>
<form id="form-POSTapi-usersar--id-" data-method="POST" data-path="api/usersar/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-usersar--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/usersar/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-usersar--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-usersar--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-usersar--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer en bulk des utilisateurs (désarchiver)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/restore"
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
    'http://localhost/api/users/restore',
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
<div id="execution-results-POSTapi-users-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-users-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-restore"></code></pre>
</div>
<form id="form-POSTapi-users-restore" data-method="POST" data-path="api/users/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-users-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-restore" data-component="header"></label>
</p>
</form>


## maj du mot de passe d&#039;un utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/userspassword" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"current_password":"dolorem","new_password":"voluptatem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/userspassword"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_password": "dolorem",
    "new_password": "voluptatem"
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
    'http://localhost/api/userspassword',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'current_password' => 'dolorem',
            'new_password' => 'voluptatem',
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
<div id="execution-results-POSTapi-userspassword" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-userspassword"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-userspassword"></code></pre>
</div>
<div id="execution-error-POSTapi-userspassword" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-userspassword"></code></pre>
</div>
<form id="form-POSTapi-userspassword" data-method="POST" data-path="api/userspassword" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-userspassword', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/userspassword</code></b>
</p>
<p>
<label id="auth-POSTapi-userspassword" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-userspassword" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>current_password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="current_password" data-endpoint="POSTapi-userspassword" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>new_password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="new_password" data-endpoint="POSTapi-userspassword" data-component="body" required  hidden>
<br>

</p>

</form>


## Archiver/Restorer un groupe d&#039;utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/bulk-delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"usersids":["vitae"],"action":"delete"}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/bulk-delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "usersids": [
        "vitae"
    ],
    "action": "delete"
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
    'http://localhost/api/users/bulk-delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'usersids' => [
                'vitae',
            ],
            'action' => 'delete',
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
<div id="execution-results-POSTapi-users-bulk-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-bulk-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-bulk-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-users-bulk-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-bulk-delete"></code></pre>
</div>
<form id="form-POSTapi-users-bulk-delete" data-method="POST" data-path="api/users/bulk-delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-bulk-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/bulk-delete</code></b>
</p>
<p>
<label id="auth-POSTapi-users-bulk-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-bulk-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>usersids</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="usersids.0" data-endpoint="POSTapi-users-bulk-delete" data-component="body" required  hidden>
<input type="text" name="usersids.1" data-endpoint="POSTapi-users-bulk-delete" data-component="body" hidden>
<br>

</p>
<p>
<b><code>action</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="action" data-endpoint="POSTapi-users-bulk-delete" data-component="body" required  hidden>
<br>
The value must be one of <code>delete</code> or <code>restore</code>.
</p>

</form>


## Modifier la classe (et infos associées) d&#039;une liste d&#039;utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/switch-classe" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUsers":[6,3],"idClasse":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/switch-classe"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUsers": [
        6,
        3
    ],
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
    'http://localhost/api/users/switch-classe',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUsers' => [
                6,
                3,
            ],
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
<div id="execution-results-POSTapi-users-switch-classe" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-switch-classe"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-switch-classe"></code></pre>
</div>
<div id="execution-error-POSTapi-users-switch-classe" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-switch-classe"></code></pre>
</div>
<form id="form-POSTapi-users-switch-classe" data-method="POST" data-path="api/users/switch-classe" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-switch-classe', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/switch-classe</code></b>
</p>
<p>
<label id="auth-POSTapi-users-switch-classe" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-switch-classe" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUsers</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idUsers.0" data-endpoint="POSTapi-users-switch-classe" data-component="body" required  hidden>
<input type="number" name="idUsers.1" data-endpoint="POSTapi-users-switch-classe" data-component="body" hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-users-switch-classe" data-component="body" required  hidden>
<br>

</p>

</form>


## Modifier la classe secondaire d&#039;une liste d&#039;utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/switch-classe-secondaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUsers":[15,12],"idClasseSecondaire":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/switch-classe-secondaire"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUsers": [
        15,
        12
    ],
    "idClasseSecondaire": 3
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
    'http://localhost/api/users/switch-classe-secondaire',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUsers' => [
                15,
                12,
            ],
            'idClasseSecondaire' => 3,
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
<div id="execution-results-POSTapi-users-switch-classe-secondaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-switch-classe-secondaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-switch-classe-secondaire"></code></pre>
</div>
<div id="execution-error-POSTapi-users-switch-classe-secondaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-switch-classe-secondaire"></code></pre>
</div>
<form id="form-POSTapi-users-switch-classe-secondaire" data-method="POST" data-path="api/users/switch-classe-secondaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-switch-classe-secondaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/switch-classe-secondaire</code></b>
</p>
<p>
<label id="auth-POSTapi-users-switch-classe-secondaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-switch-classe-secondaire" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUsers</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idUsers.0" data-endpoint="POSTapi-users-switch-classe-secondaire" data-component="body" required  hidden>
<input type="number" name="idUsers.1" data-endpoint="POSTapi-users-switch-classe-secondaire" data-component="body" hidden>
<br>

</p>
<p>
<b><code>idClasseSecondaire</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasseSecondaire" data-endpoint="POSTapi-users-switch-classe-secondaire" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/users/ad" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/ad"
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
    'http://localhost/api/users/ad',
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
<div id="execution-results-PUTapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--id-"></code></pre>
</div>
<form id="form-PUTapi-users--id-" data-method="PUT" data-path="api/users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/users/ut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/ut"
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
    'http://localhost/api/users/ut',
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
<div id="execution-results-DELETEapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-users--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-users--id-"></code></pre>
</div>
<form id="form-DELETEapi-users--id-" data-method="DELETE" data-path="api/users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les utilisateurs ayant déjà versé un certain montant

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/users/payments" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":3,"nbreItems":13,"idSchool":18,"idSection":15,"idClasse":17,"payment":323.71,"hasPaid":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/users/payments"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 3,
    "nbreItems": 13,
    "idSchool": 18,
    "idSection": 15,
    "idClasse": 17,
    "payment": 323.71,
    "hasPaid": false
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
    'http://localhost/api/users/payments',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 3,
            'nbreItems' => 13,
            'idSchool' => 18,
            'idSection' => 15,
            'idClasse' => 17,
            'payment' => 323.71,
            'hasPaid' => false,
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
<div id="execution-results-POSTapi-users-payments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-payments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-payments"></code></pre>
</div>
<div id="execution-error-POSTapi-users-payments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-payments"></code></pre>
</div>
<form id="form-POSTapi-users-payments" data-method="POST" data-path="api/users/payments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-payments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/payments</code></b>
</p>
<p>
<label id="auth-POSTapi-users-payments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-payments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-users-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-users-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-users-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-users-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-users-payments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="payment" data-endpoint="POSTapi-users-payments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>hasPaid</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-users-payments" hidden><input type="radio" name="hasPaid" value="true" data-endpoint="POSTapi-users-payments" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-users-payments" hidden><input type="radio" name="hasPaid" value="false" data-endpoint="POSTapi-users-payments" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Vérifier la solvabilité d&#039;un élève à une période donnée

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/student-solvency" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[8,9]}'

```

```javascript
const url = new URL(
    "http://localhost/api/student-solvency"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        8,
        9
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
    'http://localhost/api/student-solvency',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                8,
                9,
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
<div id="execution-results-POSTapi-student-solvency" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-student-solvency"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-student-solvency"></code></pre>
</div>
<div id="execution-error-POSTapi-student-solvency" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-student-solvency"></code></pre>
</div>
<form id="form-POSTapi-student-solvency" data-method="POST" data-path="api/student-solvency" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-student-solvency', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/student-solvency</code></b>
</p>
<p>
<label id="auth-POSTapi-student-solvency" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-student-solvency" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-student-solvency" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-student-solvency" data-component="body" hidden>
<br>

</p>

</form>


## api/modify-annual-decision

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/modify-annual-decision" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"annualDecisions":[{"idStudent":7,"decision":"ut"}],"idOptionLevel":4,"idClasse":13,"idSchool":11,"successValue":9711315.40959549,"automatic":false,"admissionText":"dignissimos","repeatText":"quidem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/modify-annual-decision"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "annualDecisions": [
        {
            "idStudent": 7,
            "decision": "ut"
        }
    ],
    "idOptionLevel": 4,
    "idClasse": 13,
    "idSchool": 11,
    "successValue": 9711315.40959549,
    "automatic": false,
    "admissionText": "dignissimos",
    "repeatText": "quidem"
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
    'http://localhost/api/modify-annual-decision',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'annualDecisions' => [
                [
                    'idStudent' => 7,
                    'decision' => 'ut',
                ],
            ],
            'idOptionLevel' => 4,
            'idClasse' => 13,
            'idSchool' => 11,
            'successValue' => 9711315.40959549,
            'automatic' => false,
            'admissionText' => 'dignissimos',
            'repeatText' => 'quidem',
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
<div id="execution-results-POSTapi-modify-annual-decision" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-modify-annual-decision"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-modify-annual-decision"></code></pre>
</div>
<div id="execution-error-POSTapi-modify-annual-decision" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-modify-annual-decision"></code></pre>
</div>
<form id="form-POSTapi-modify-annual-decision" data-method="POST" data-path="api/modify-annual-decision" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-modify-annual-decision', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/modify-annual-decision</code></b>
</p>
<p>
<label id="auth-POSTapi-modify-annual-decision" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-modify-annual-decision" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>annualDecisions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>annualDecisions[].idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="annualDecisions.0.idStudent" data-endpoint="POSTapi-modify-annual-decision" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>annualDecisions[].decision</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="annualDecisions.0.decision" data-endpoint="POSTapi-modify-annual-decision" data-component="body" required  hidden>
<br>

</p>
</details>
</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>successValue</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="successValue" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>automatic</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-modify-annual-decision" hidden><input type="radio" name="automatic" value="true" data-endpoint="POSTapi-modify-annual-decision" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-modify-annual-decision" hidden><input type="radio" name="automatic" value="false" data-endpoint="POSTapi-modify-annual-decision" data-component="body" required ><code>false</code></label>
<br>

</p>
<p>
<b><code>admissionText</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="admissionText" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>repeatText</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="repeatText" data-endpoint="POSTapi-modify-annual-decision" data-component="body"  hidden>
<br>

</p>

</form>



