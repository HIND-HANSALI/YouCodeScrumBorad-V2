// document.getElementById("task-delete-btn2").addEventListener('click', confirmDelete);
// function confirmDelete(){
//     if(confirm("Are you sure you want to delete?") == true){
//         document.getElementById('task-delete-btn').click();

//     }

// }
document.getElementById("task-delete-btn2").addEventListener('click',confirmDelete) ;

function confirmDelete(){
    if(confirm("Are you sure you want to delete?") == true){
        console.log("here if");
        document.getElementById('task-delete-btn').click();
    }
}