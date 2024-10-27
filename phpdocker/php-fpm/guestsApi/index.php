<html>
	<head>
		<title>GuestsApi</title>
	</head>
	<body>

		<p>/init - Инициализация бд<p>
		<p>/set - Принимает Post запросы с параметрами, в случае ошибки выдает json с ошибкой. В случае с успеха выдает json с сообщением об успешном выполнении.<br>
		Получаемые параметры:<br>
		<ul>
			<li>name - имя записываемого гостя(обязательный)</li>
			<li>family - фамилия записываемого гостя(обязательный)</li>
			<li>telephone - номер телефона записываемого гостя(обязательный)<br> что бы работала подстановка страны от номера телефона номер должен имет формат начинающийся с + и страна не должна быть явно указана </li>
			<li>email - почтовый адрес записываемого гостя</li>
			<li>country - страна записываемого гостя</li>
		</ul>
		</p>
		<p>/get - Принимает Post запросы с параметрами, в случае ошибки выдает json с ошибкой. В случае с успеха выдает json с данными гостя.<br>
		Получаемые параметры:<br>
		<ul>
			<li>telephone - номер телефона гостя данные которго хотим получить(обязательный) </li>
		</ul>
		</p>
		<p>/update - Принимает Post запросы с параметрами, в случае ошибки выдает json с ошибкой. В случае с успеха выдает json с данными гостя.<br>
		Получаемые параметры:<br>
		<ul>
			<li>telephone - номер телефона данные корого хотим обновить гостя(обязательный) </li>
			<li>name - имя если хотим обновить данный параметр гостя</li>
			<li>family - фамилия если хотим обновить данный параметр гостя</li>
			<li>new_telephone - новый номер телефона обновить данный параметр гостя<br> что бы работала подстановка страны от номера телефона номер должен имет формат начинающийся с + и страна не должна быть явно указана</li>
			<li>email - почтовый адрес обновить данный параметр гостя</li>
			<li>country - страна обновить данный параметр гостя</li>
		</ul>
		</p>
		<p>/delete - Принимает Post запросы с параметрами, в случае ошибки выдает json с ошибкой. В случае с успеха выдает json с сообщением об успешном выполнении.<br>
		Получаемые параметры:<br>
		<ul>
			<li>telephone - номер телефона удаляемого из базы гостя(обязательный) </li>
		</ul>
		</p>
	</body>
</html>
