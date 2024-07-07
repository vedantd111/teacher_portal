document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('student-modal');
    const closeModalBtn = document.querySelector('.close');

    window.openAddStudentModal = () => {
        document.getElementById('student-form').reset();
        document.getElementById('student-id').value = '';
        modal.style.display = 'flex';
    };

    window.closeModal = () => {
        modal.style.display = 'none';
    };

    window.editStudent = (id, name, subject, marks) => {
        document.getElementById('student-id').value = id;
        document.getElementById('student-name').value = name;
        document.getElementById('student-subject').value = subject;
        document.getElementById('student-marks').value = marks;
        modal.style.display = 'flex';
    };

    window.deleteStudent = (id) => {
        if (confirm('Are you sure you want to delete this student?')) {
            window.location.href = `delete_student.php?id=${id}`;
        }
    };

    closeModalBtn.onclick = closeModal;

    window.onclick = (event) => {
        if (event.target === modal) {
            closeModal();
        }
    };
});
