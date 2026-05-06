package com.clinic.clinic_app.controller;

import com.clinic.clinic_app.dto.UserRegistrationDto;
import com.clinic.clinic_app.service.AnnouncementService;
import com.clinic.clinic_app.service.DoctorService;
import com.clinic.clinic_app.service.MedicalServiceService;
import com.clinic.clinic_app.service.UserService;
import jakarta.validation.Valid;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;

@Controller
public class AuthController {

    private final UserService userService;
    private final DoctorService doctorService;
    private final MedicalServiceService medicalServiceService;
    private final AnnouncementService announcementService;

    public AuthController(
            UserService userService,
            DoctorService doctorService,
            MedicalServiceService medicalServiceService,
            AnnouncementService announcementService) {
        this.userService = userService;
        this.doctorService = doctorService;
        this.medicalServiceService = medicalServiceService;
        this.announcementService = announcementService;
    }

    @GetMapping("/")
    /**
     * Отображает публичную главную страницу с динамическими данными из базы данных.
     *
     * @param model модель для передачи врачей, услуг и объявлений
     * @return страница главной
     */
    public String home(Model model) {
        model.addAttribute("doctors", doctorService.findActive());
        model.addAttribute("services", medicalServiceService.findActive());
        model.addAttribute("announcements", announcementService.findLatest());
        return "index";
    }

    @GetMapping("/login")
    /**
     * Отображает страницу входа в систему.
     *
     * @return страница входа
     */
    public String login() {
        return "login";
    }

    @GetMapping("/register")
    /**
     * Отображает форму регистрации пользователя.
     *
     * @param model модель для передачи пустой формы регистрации
     * @return страница регистрации
     */
    public String registerPage(Model model) {
        model.addAttribute("user", new UserRegistrationDto());
        return "register";
    }

    @PostMapping("/register")
    /**
     * Обрабатывает регистрацию пользователя и проверяет уникальность логина.
     *
     * @param dto отправленные данные регистрации
     * @param result результат валидации формы
     * @param model модель для передачи сообщения об успешной регистрации
     * @return страница регистрации с ошибками или страница входа после успешной регистрации
     */
    public String register(
            @Valid @ModelAttribute("user") UserRegistrationDto dto,
            BindingResult result,
            Model model) {
        if (userService.usernameExists(dto.getUsername())) {
            result.rejectValue("username", "username.exists", "Такой логин уже занят");
        }
        if (result.hasErrors()) {
            return "register";
        }

        userService.registerUser(dto);
        model.addAttribute("success", "Регистрация завершена. Теперь можно войти.");
        return "login";
    }

    @GetMapping("/dashboard")
    /**
     * Отображает защищённый личный кабинет пользователя.
     *
     * @return страница личного кабинета
     */
    public String dashboard() {
        return "dashboard";
    }
}
