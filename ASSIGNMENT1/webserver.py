import socket
import sys

args = sys.argv

def receive(client_connection):
    request_data = b''
    while True:
        new_data = client_connection.recv(4098)
        if len(new_data) == 0:
            # client disconnected
            return None, None
        request_data += new_data
        if b'\r\n\r\n' in request_data:
            break

    parts = request_data.split(b'\r\n\r\n',1)
    header = parts[0]
    body = parts[1]

    if b'Content-Length' in header:
        headers = header.split(b'\r\n')
        for h in headers:
            if h.startswith(b'Content-Length'):
                bodyLength = int(h.split(b' ')[1])
                break
    else:
        bodyLength = 0

    while len(body) < bodyLength:
        body += client_connection.recv(4098)

    header = header.decode('UTF-8')
    body = body.decode('UTF-8')

    return header, body

HOST, PORT = args[1], args[2]

listen_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listen_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listen_socket.bind((HOST, int(PORT)))
listen_socket.listen(1)
print(f'Serving HTTP on port {PORT} ...')

notFoundPage = """\
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
Connection: close
""" 
notFoundPage = notFoundPage.replace('\n','\r\n')
notFoundPage += """
<html>
<body>
<b>404 File Not Found</b>!
</body>
</html>
"""
notFoundPage = notFoundPage.encode(encoding='UTF-8')
while True:
    client_connection, client_address = listen_socket.accept()
    header,body = receive(client_connection)
    header = header.split('\r\n')
    request_data=header[0].split(' ')
    request_data = request_data[1]
    path_to_data = args[3]+request_data
    if 'png' in request_data:
        http_response = """\
HTTP/1.1 200 OK
Content-Type: image/png
Connection: close

"""
        http_response = http_response.replace('\n','\r\n').encode('UTF-8')
        try:
            with open(path_to_data, 'rb') as f:
                http_response += f.read()
        except FileNotFoundError:
            http_response = notFoundPage
    elif 'jpg' in request_data:
        http_response = """\
HTTP/1.1 200 OK
Content-Type: image/jpeg
Connection: close
"""
        http_response = http_response.replace('\n','\r\n').encode('UTF-8')
        try:
            with open(path_to_data, 'rb') as f:
                http_response += f.read()
        except FileNotFoundError:
            http_response = notFoundPage
    elif 'html' in request_data:
        http_response = """\
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
Connection: close
"""
        http_response = http_response.replace('\n','\r\n')
        try:
            with open(path_to_data, 'r+') as f:
                http_response += f.read()
            http_response = http_response.encode(encoding='UTF-8')
        except FileNotFoundError:
            http_response = notFoundPage

    else:
        http_response = """\
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
Connetction: close
""" 
        http_response = http_response.replace('\n','\r\n')
        http_response += """
<html>
<body>
<b>Format Not Supported</b>!
</body>
</html>
"""
        http_response = http_response.encode(encoding='UTF-8')
    print(http_response)
    client_connection.sendall(http_response)
    client_connection.close()