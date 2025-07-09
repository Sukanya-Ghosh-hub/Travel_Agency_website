document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    if (currentTheme === 'dark') {
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
    
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        themeToggle.innerHTML = newTheme === 'dark' 
            ? '<i class="fas fa-sun"></i>' 
            : '<i class="fas fa-moon"></i>';
    });
    
    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    mobileMenuBtn.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        mobileMenuBtn.innerHTML = navLinks.classList.contains('active') 
            ? '<i class="fas fa-times"></i>' 
            : '<i class="fas fa-bars"></i>';
    });
    
    // Close mobile menu when clicking a link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Destination Data
    const destinations = [
        {
            id: 1,
            name: 'Santorini, Greece',
            image: 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.9
        },
        {
            id: 2,
            name: 'Kyoto, Japan',
            image: 'https://images.unsplash.com/photo-1492571350019-22de08371fd3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.8
        },
        {
            id: 3,
            name: 'Bali, Indonesia',
            image: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.7
        },
        {
            id: 4,
            name: 'Paris, France',
            image: 'https://images.unsplash.com/photo-1431274172761-fca41d930114?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.9
        },
        {
            id: 5,
            name: 'New York, USA',
            image: 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.6
        },
        {
            id: 6,
            name: 'Sydney, Australia',
            image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            rating: 4.7
        }
    ];
    
    // Package Data
    const packages = [
        {
            id: 1,
            title: 'Greek Island Hopping',
            image: 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '7 Days',
            category: 'luxury',
            price: '$2,499',
            rating: 5
        },
        {
            id: 2,
            title: 'Japanese Cultural Tour',
            image: 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '10 Days',
            category: 'adventure',
            price: '$3,199',
            rating: 4
        },
        {
            id: 3,
            title: 'Bali Wellness Retreat',
            image: 'https://images.unsplash.com/photo-1562790351-d273a961e0e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '5 Days',
            category: 'luxury',
            price: '$1,899',
            rating: 5
        },
        {
            id: 4,
            title: 'European Family Adventure',
            image: 'https://images.unsplash.com/photo-1503917988258-f87a78e3c995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '14 Days',
            category: 'family',
            price: '$4,299',
            rating: 4
        },
        {
            id: 5,
            title: 'Amazon Jungle Expedition',
            image: 'https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '8 Days',
            category: 'adventure',
            price: '$2,799',
            rating: 5
        },
        {
            id: 6,
            title: 'Safari in Tanzania',
            image: 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            duration: '12 Days',
            category: 'adventure',
            price: '$5,499',
            rating: 5
        }
    ];
    
    // Testimonial Data
    const testimonials = [
        {
            id: 1,
            name: 'Sarah Johnson',
            position: 'Travel Blogger',
            avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
            quote: 'Voyager made our honeymoon absolutely magical. Every detail was perfect, and we didn\'t have to worry about a thing. Highly recommend their luxury packages!'
        },
        {
            id: 2,
            name: 'Michael Chen',
            position: 'Adventure Enthusiast',
            avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
            quote: 'The Amazon expedition was the most thrilling experience of my life. The guides were knowledgeable and the itinerary was packed with amazing activities.'
        },
        {
            id: 3,
            name: 'Emma Rodriguez',
            position: 'Family Traveler',
            avatar: 'https://randomuser.me/api/portraits/women/63.jpg',
            quote: 'Traveling with kids can be stressful, but Voyager took care of everything. Our European tour was perfectly paced for our family. We\'ll definitely book with them again!'
        }
    ];
    
    // Render Destinations
    const destinationGrid = document.querySelector('.destination-grid');
    
    destinations.forEach(destination => {
        const card = document.createElement('div');
        card.className = 'destination-card glass';
        card.innerHTML = `
            <img src="${destination.image}" alt="${destination.name}">
            <div class="destination-info">
                <h3>${destination.name}</h3>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>${destination.rating} ★</span>
                </div>
            </div>
        `;
        destinationGrid.appendChild(card);
    });
    
    // Render Packages
    const packageGrid = document.querySelector('.package-grid');
    
    function renderPackages(category = 'all') {
        packageGrid.innerHTML = '';
        
        const filteredPackages = category === 'all' 
            ? packages 
            : packages.filter(pkg => pkg.category === category);
        
        filteredPackages.forEach(pkg => {
            const stars = '★'.repeat(pkg.rating) + '☆'.repeat(5 - pkg.rating);
            
            const card = document.createElement('div');
            card.className = 'package-card glass';
            card.innerHTML = `
                <img src="${pkg.image}" alt="${pkg.title}">
                <div class="package-content">
                    <div class="meta">
                        <span class="duration">${pkg.duration}</span>
                        <span class="category">${pkg.category.charAt(0).toUpperCase() + pkg.category.slice(1)}</span>
                    </div>
                    <h3>${pkg.title}</h3>
                    <div class="rating">${stars}</div>
                    <div class="price">From ${pkg.price}</div>
                    <button class="btn primary">View Details</button>
                </div>
            `;
            packageGrid.appendChild(card);
        });
    }
    
    // Initial render
    renderPackages();
    
    // Package Tab Filtering
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            renderPackages(category);
        });
    });
    
    // Testimonial Slider
    let currentTestimonial = 0;
    const testimonialContainer = document.querySelector('.testimonial-slider');
    
    function renderTestimonial(index) {
        const testimonial = testimonials[index];
        
        const testimonialCard = document.createElement('div');
        testimonialCard.className = 'testimonial-card active';
        testimonialCard.innerHTML = `
            <img src="${testimonial.avatar}" alt="${testimonial.name}" class="avatar">
            <p class="quote">${testimonial.quote}</p>
            <h4 class="name">${testimonial.name}</h4>
            <p class="position">${testimonial.position}</p>
        `;
        
        // Clear existing testimonials
        const existingCards = document.querySelectorAll('.testimonial-card');
        existingCards.forEach(card => card.remove());
        
        testimonialContainer.insertBefore(testimonialCard, document.querySelector('.slider-controls'));
    }
    
    // Initial render
    renderTestimonial(currentTestimonial);
    
    // Slider controls
    document.querySelector('.prev').addEventListener('click', function() {
        currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
        renderTestimonial(currentTestimonial);
    });
    
    document.querySelector('.next').addEventListener('click', function() {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        renderTestimonial(currentTestimonial);
    });
    
    // Auto-rotate testimonials
    setInterval(() => {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        renderTestimonial(currentTestimonial);
    }, 8000);
    
    // Form Submission
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple validation
            const inputs = this.querySelectorAll('input, textarea');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = 'red';
                    isValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });
            
            if (isValid) {
                // In a real app, you would send this to your server
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
    }

    // Book now form
    const bookNow = document.getElementById('book-now');
    bookNow.addEventListener('click', ()=>{
        window.open('../Form/index.html')
    })
    
    // Scroll Reveal Animation
    const scrollReveal = ScrollReveal({
        origin: 'bottom',
        distance: '60px',
        duration: 1000,
        delay: 200,
        reset: true
    });
    
    scrollReveal.reveal('.section-header, .destination-card, .package-card, .testimonial-card, .contact-container', {
        interval: 200
    });
});