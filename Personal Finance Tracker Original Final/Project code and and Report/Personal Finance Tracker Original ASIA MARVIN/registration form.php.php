<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration Form</title>
    <nav>
    <nav>
        <a href="registration form.php.php">Registration</a>
        <a href="student's data.php.php">Student</a>
        <a href="Course.php.PHP">Course</a>
        <a href="department form.php.php">Department</a>
        <a href="marks.php.php">Marks</a>
    </nav> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        .form-section {
            flex: 1;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-right: 20px;
        }
        .display-section {
            flex: 1;
            background-color: #e9f7ef;
            border-radius: 8px;
            padding: 20px;
            border-left: 2px solid #1abc9c;
        }
        h2 {
            color: #1abc9c;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], input[type="button"] {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #16a085;
        }
        .message {
            color: #1abc9c;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <h2>Course Registration Form</h2>
        <form id="registrationForm">
            <label for="course_name">Course Name:</label>
            <select id="course_name" name="course_name" required>
                <option value="">Select Course</option>
                <option value="Computer Science">Computer Science</option>
                <option value="DEIT">DEIT</option>
                <option value="Data Science">Data Science</option>
                <option value="Robotics">Robotics</option>
                <option value="Electronics">Electronics</option>
            </select>

            <label for="course_code">Course Code:</label>
            <input type="text" id="course_code" name="course_code" required>

            <label for="course_head">Course Head:</label>
            <input type="text" id="course_head" name="course_head" required>

            <label for="year">Year:</label>
            <select id="year" name="year" required>
                <option value="">Select Year</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <label for="semester">Semester:</label>
            <select id="semester" name="semester" required>
                <option value="">Select Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>

            <input type="submit" value="Register" onclick="submitForm(event)">
            <input type="button" value="Edit" onclick="editForm()">
            <input type="button" value="Delete" onclick="deleteForm()">
        </form>
        <div class="message" id="message"></div>
    </div>

    <div class="display-section">
        <h2>Submitted Details</h2>
        <div id="submittedDetails"></div>
    </div>
</div>

<script>
    
    const form = document.getElementById('registrationForm');
    const messageDiv = document.getElementById('message');
    const detailsDiv = document.getElementById('submittedDetails');

    let courseData = null;

    function submitForm(event) {
        event.preventDefault();
        
        const formData = new FormData(form);
        courseData = {
            courseName: formData.get('course_name'),
            courseCode: formData.get('course_code'),
            courseHead: formData.get('course_head'),
            year: formData.get('year'),
            semester: formData.get('semester'),
        };
        
      
        messageDiv.textContent = "Submission successful!";
        
     
        displayDetails(courseData);
    
        form.reset();
    }

    function displayDetails(data) {
        detailsDiv.innerHTML = `
            <p><strong>Course Name:</strong> ${data.courseName}</p>
            <p><strong>Course Code:</strong> ${data.courseCode}</p>
            <p><strong>Course Head:</strong> ${data.courseHead}</p>
            <p><strong>Year:</strong> ${data.year}</p>
            <p><strong>Semester:</strong> ${data.semester}</p>
        `;
    }

    function editForm() {
        if (courseData) {
            document.getElementById('course_name').value = courseData.courseName;
            document.getElementById('course_code').value = courseData.courseCode;
            document.getElementById('course_head').value = courseData.courseHead;
            document.getElementById('year').value = courseData.year;
            document.getElementById('semester').value = courseData.semester;
            messageDiv.textContent = "Edit the course details as needed.";
        } else {
            messageDiv.textContent = "No course data found to edit.";
        }
    }

    function deleteForm() {
        courseData = null;
        form.reset();
        detailsDiv.innerHTML = ""; 
        messageDiv.textContent = "Submission deleted.";
    }
</script>

</body>
</html>