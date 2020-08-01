var http = require('http');

http.createServer(function (request, response) {
    console.log('request starting...');

    response.writeHead(200, { 'Content-Type': 'text/html' });

    var html = '<h1>Test</h1>';

    response.end(html, 'utf-8');
}).listen(8080);