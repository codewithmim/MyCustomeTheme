document.addEventListener('DOMContentLoaded', () => { 
    const buttons = document.querySelectorAll('.filter-btn'); 
    const postGrid = document.getElementById('post-grid'); 
    
    buttons.forEach(button => { 
     button.addEventListener('click', () => { 
        
    const category = button.dataset.category; 
    
    buttons.forEach(btn => btn.classList.remove('active'));
    
    button.classList.add('active'); 
    jQuery.post(ajax_object.ajax_url, { 
    
        action: 'filter_posts', 
    
        category: category,
     }, response => { 
        if (response.success) { 
            postGrid.innerHTML = response.data.html; 
   
                     }
                });
             });
        });
     });