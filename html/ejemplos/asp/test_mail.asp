<%@LANGUAGE="VBSCRIPT" %>
<!--METADATA TYPE="TypeLib" FILE="E:\WINDOWS\system32\cdosys.dll" -->

<!-- Formulario para completar con los datos -->
<form action="test_mail.asp" method="POST">
	Usuario smtp: <input type="text" value="" name="usuario"></input> <br />
	(El usuario puede encontrarlo en el panel de control, E-mail, Administrar cuentas)<br/>
	Contrase�a smtp: <input type="password" value="" name="passwd"></input><br/>
	(La contrase�a de su correo electr�nico)<br/>
	E-mail destinatario: <input type="text" name="destinatario" width="50"></input><br/>
	<input type="submit" value="Enviar e-mail" /><input type="hidden" name="enviar" value="1"/>
</form>
<!-- Fin Formulario para completar con los datos -->

<%
' Se verifica que los datos han sido enviados desde el formulario, para la validaci�n con el SMTP
If Request("enviar") = 1 Then
	If Not Request("usuario") = "" And Not Request("passwd") = "" And Not Request("destinatario") = "" Then
		' Se crean los objetos necesarios para el env�o del correo
		Set oMail = Server.CreateObject("CDO.Message") 
		Set iConf = Server.CreateObject("CDO.Configuration") 
		Set Flds = iConf.Fields 
		
		' Se configuran los parametros necesarios para el env�o
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/sendusing") = 1 
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "http://127.0.0.1" 
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 10 
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
		' Se completan los datos del usuario y la contrase�a necesarios para el envio
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/sendusername") = Request("usuario") 'usuario smtp
		iConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/sendpassword") = Request("passwd")  'password para STMP
		iConf.Fields.Update
		' Se asignan las propiedades de configuraci�n al objeto
		Set oMail.Configuration = iConf 
	
		' Destinatario del correo
		oMail.To = Request("destinatario")
		' Remitente del correo
		oMail.From = "noreply@ferozowindows.com.ar"
		' Subject o asunto
		oMail.Subject = "E-mail de prueba"
		' Cuerpo del mensaje
		oMail.TextBody = "Este es un e-mail enviado desde la p�gina de ejemplo de Ferozo Windows Edition"
		' Se env�a el correo
		oMail.Send
		' Se destruyen los objetos
		Set iConf = Nothing 
		Set Flds = Nothing
	Else
		' Respuesta en caso de que no se completen todos los datos
		Response.Write("Complete todos los campos para ejecutar el ejemplo")
	End If
End If
%>
