
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

let scrollTriggers = [];

function initAnimations() {
    // Kill existing ScrollTriggers to prevent memory leaks on Livewire Navigate
    scrollTriggers.forEach(trigger => trigger.kill());
    scrollTriggers = [];

    // Support for both new data-animate attribute and old .reveal-on-scroll class
    const animateElements = document.querySelectorAll('[data-animate], .reveal-on-scroll');

    animateElements.forEach((el) => {
        // Remove old classes if they exist so GSAP can take over cleanly
        el.classList.remove('opacity-0', 'translate-y-8', 'animate-fade-in-up');
        
        let animationType = el.getAttribute('data-animate');
        if (!animationType && el.classList.contains('reveal-on-scroll')) {
            animationType = 'fade-up';
        }

        const delayMs = el.getAttribute('data-delay') || 0;
        let delay = parseInt(delayMs) / 1000;
        
        // Handle old animation-delay classes
        if (!delay) {
            const delayClass = Array.from(el.classList).find(c => c.startsWith('animation-delay-'));
            if (delayClass) {
                const ms = delayClass.replace('animation-delay-', '');
                delay = parseInt(ms) / 1000;
            }
        }
        
        let fromVars = { opacity: 0 };
        let toVars = { 
            opacity: 1, 
            duration: 1.1, 
            ease: "power2.out", 
            delay: delay,
            scrollTrigger: {
                trigger: el,
                start: "top 90%",
                toggleActions: "play none none none"
            }
        };

        if (animationType === 'fade-up') {
            fromVars.y = 40;
            toVars.y = 0;
        } else if (animationType === 'fade-down') {
            fromVars.y = -40;
            toVars.y = 0;
        } else if (animationType === 'fade-left') {
            fromVars.x = 40;
            toVars.x = 0;
        } else if (animationType === 'fade-right') {
            fromVars.x = -40;
            toVars.x = 0;
        } else if (animationType === 'scale-in') {
            fromVars.scale = 0.8;
            toVars.scale = 1;
        } else if (animationType === 'stagger-children') {
            const children = el.querySelectorAll(':scope > *');
            gsap.set(children, { opacity: 0, y: 30 });
            
            const st = ScrollTrigger.create({
                trigger: el,
                start: "top 90%",
                onEnter: () => {
                    gsap.to(children, {
                        opacity: 1,
                        y: 0,
                        duration: 1.0,
                        stagger: 0.18,
                        ease: "power2.out",
                        delay: delay
                    });
                }
            });
            scrollTriggers.push(st);
            return; // Skip normal animation logic
        }

        // Apply initial state
        gsap.set(el, fromVars);
        
        // Create animation
        const st = ScrollTrigger.create({
            trigger: el,
            start: toVars.scrollTrigger.start,
            toggleActions: toVars.scrollTrigger.toggleActions,
            onEnter: () => gsap.to(el, toVars)
        });
        scrollTriggers.push(st);
    });
}

document.addEventListener('DOMContentLoaded', initAnimations);
document.addEventListener('livewire:navigated', () => {
    setTimeout(initAnimations, 50);
});
document.addEventListener('livewire:navigating', () => {
    scrollTriggers.forEach(trigger => trigger.kill());
    scrollTriggers = [];
});
