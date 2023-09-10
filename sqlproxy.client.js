
function request(url, token, query, parameters, callback)
{
    token = String(token);
    query = String(query);

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            callback(res);
        }
    };

    let data = {
        "token": token,
        "query": query
    }

    for (let i = 0; i < parameters.length; i++) {
        data['parm'+(i+1)] = parameters[i];
    }

    xhr.open('POST',url, true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify(data))
}