package com.clinic.clinic_app.controller;

import com.clinic.clinic_app.dto.DoctorForm;
import com.clinic.clinic_app.dto.MedicalServiceForm;
import com.clinic.clinic_app.dto.UserRegistrationDto;
import com.clinic.clinic_app.model.AppointmentStatus;
import com.clinic.clinic_app.service.AppointmentService;
import com.clinic.clinic_app.service.DoctorService;
import com.clinic.clinic_app.service.MedicalServiceService;
import com.clinic.clinic_app.service.UserService;
import jakarta.validation.Valid;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;

@Controller
@RequestMapping("/admin")
public class AdminController {

    private final AppointmentService appointmentService;
    private final DoctorService doctorService;
    private final MedicalServiceService medicalServiceService;
    private final UserService userService;

    public AdminController(
            AppointmentService appointmentService,
            DoctorService doctorService,
            MedicalServiceService medicalServiceService,
            UserService userService) {
        this.appointmentService = appointmentService;
        this.doctorService = doctorService;
        this.medicalServiceService = medicalServiceService;
        this.userService = userService;
    }

    @GetMapping
    /**
     * Отображает панель администратора.
     *
     * @return страница панели администратора
     */
    public String dashboard() {
        return "admin/index";
    }

    @GetMapping("/appointments")
    /**
     * Отображает все заявки на приём для управления администратором.
     *
     * @param model модель для передачи заявок и доступных статусов
     * @return страница управления заявками
     */
    public String appointments(Model model) {
        model.addAttribute("appointments", appointmentService.findAll());
        model.addAttribute("statuses", AppointmentStatus.values());
        return "admin/appointments";
    }

    @PostMapping("/appointments/{id}/status")
    /**
     * Обновляет статус заявки на приём.
     *
     * @param id идентификатор заявки
     * @param status новый статус заявки
     * @return перенаправление на страницу управления заявками
     */
    public String updateAppointmentStatus(@PathVariable Long id, @RequestParam AppointmentStatus status) {
        appointmentService.updateStatus(id, status);
        return "redirect:/admin/appointments";
    }

    @PostMapping("/appointments/{id}/delete")
    /**
     * Удаляет заявку на приём.
     *
     * @param id идентификатор заявки
     * @return перенаправление на страницу управления заявками
     */
    public String deleteAppointment(@PathVariable Long id) {
        appointmentService.delete(id);
        return "redirect:/admin/appointments";
    }

    @GetMapping("/doctors")
    /**
     * Отображает список врачей для управления администратором.
     *
     * @param model модель для передачи списка врачей
     * @return страница управления врачами
     */
    public String doctors(Model model) {
        model.addAttribute("doctors", doctorService.findAll());
        return "admin/doctors";
    }

    @GetMapping("/doctors/new")
    /**
     * Отображает форму создания врача.
     *
     * @param model модель для передачи пустой формы врача
     * @return страница формы врача
     */
    public String newDoctor(Model model) {
        model.addAttribute("doctor", new DoctorForm());
        return "admin/doctor-form";
    }

    @PostMapping("/doctors")
    /**
     * Создаёт врача после проверки данных.
     *
     * @param form отправленные данные врача
     * @param result результат валидации формы
     * @return форма врача с ошибками или перенаправление к списку врачей
     */
    public String createDoctor(@Valid @ModelAttribute("doctor") DoctorForm form, BindingResult result) {
        if (result.hasErrors()) {
            return "admin/doctor-form";
        }
        doctorService.create(form);
        return "redirect:/admin/doctors";
    }

    @GetMapping("/doctors/{id}/edit")
    /**
     * Отображает форму редактирования врача.
     *
     * @param id идентификатор врача
     * @param model модель для передачи текущих данных врача
     * @return страница формы врача
     */
    public String editDoctor(@PathVariable Long id, Model model) {
        model.addAttribute("doctorId", id);
        model.addAttribute("doctor", doctorService.toForm(doctorService.findById(id)));
        return "admin/doctor-form";
    }

    @PostMapping("/doctors/{id}")
    /**
     * Обновляет данные врача после проверки формы.
     *
     * @param id идентификатор врача
     * @param form отправленные данные врача
     * @param result результат валидации формы
     * @param model модель для сохранения идентификатора врача при ошибках
     * @return форма врача с ошибками или перенаправление к списку врачей
     */
    public String updateDoctor(
            @PathVariable Long id,
            @Valid @ModelAttribute("doctor") DoctorForm form,
            BindingResult result,
            Model model) {
        if (result.hasErrors()) {
            model.addAttribute("doctorId", id);
            return "admin/doctor-form";
        }
        doctorService.update(id, form);
        return "redirect:/admin/doctors";
    }

    @PostMapping("/doctors/{id}/delete")
    /**
     * Удаляет врача.
     *
     * @param id идентификатор врача
     * @return перенаправление к списку врачей
     */
    public String deleteDoctor(@PathVariable Long id) {
        doctorService.delete(id);
        return "redirect:/admin/doctors";
    }

    @GetMapping("/services")
    /**
     * Отображает список медицинских услуг для управления администратором.
     *
     * @param model модель для передачи списка услуг
     * @return страница управления услугами
     */
    public String services(Model model) {
        model.addAttribute("services", medicalServiceService.findAll());
        return "admin/services";
    }

    @GetMapping("/services/new")
    /**
     * Отображает форму создания медицинской услуги.
     *
     * @param model модель для передачи пустой формы услуги
     * @return страница формы услуги
     */
    public String newService(Model model) {
        model.addAttribute("service", new MedicalServiceForm());
        return "admin/service-form";
    }

    @PostMapping("/services")
    /**
     * Создаёт медицинскую услугу после проверки данных.
     *
     * @param form отправленные данные услуги
     * @param result результат валидации формы
     * @return форма услуги с ошибками или перенаправление к списку услуг
     */
    public String createService(@Valid @ModelAttribute("service") MedicalServiceForm form, BindingResult result) {
        if (result.hasErrors()) {
            return "admin/service-form";
        }
        medicalServiceService.create(form);
        return "redirect:/admin/services";
    }

    @GetMapping("/services/{id}/edit")
    /**
     * Отображает форму редактирования медицинской услуги.
     *
     * @param id идентификатор услуги
     * @param model модель для передачи текущих данных услуги
     * @return страница формы услуги
     */
    public String editService(@PathVariable Long id, Model model) {
        model.addAttribute("serviceId", id);
        model.addAttribute("service", medicalServiceService.toForm(medicalServiceService.findById(id)));
        return "admin/service-form";
    }

    @PostMapping("/services/{id}")
    /**
     * Обновляет медицинскую услугу после проверки формы.
     *
     * @param id идентификатор услуги
     * @param form отправленные данные услуги
     * @param result результат валидации формы
     * @param model модель для сохранения идентификатора услуги при ошибках
     * @return форма услуги с ошибками или перенаправление к списку услуг
     */
    public String updateService(
            @PathVariable Long id,
            @Valid @ModelAttribute("service") MedicalServiceForm form,
            BindingResult result,
            Model model) {
        if (result.hasErrors()) {
            model.addAttribute("serviceId", id);
            return "admin/service-form";
        }
        medicalServiceService.update(id, form);
        return "redirect:/admin/services";
    }

    @PostMapping("/services/{id}/delete")
    /**
     * Удаляет медицинскую услугу.
     *
     * @param id идентификатор услуги
     * @return перенаправление к списку услуг
     */
    public String deleteService(@PathVariable Long id) {
        medicalServiceService.delete(id);
        return "redirect:/admin/services";
    }

    @GetMapping("/admins/new")
    /**
     * Отображает форму создания аккаунта администратора.
     *
     * @param model модель для передачи пустой формы регистрации
     * @return форма создания администратора
     */
    public String newAdmin(Model model) {
        model.addAttribute("user", new UserRegistrationDto());
        return "admin/admin-form";
    }

    @PostMapping("/admins")
    /**
     * Создаёт аккаунт администратора после проверки данных.
     *
     * @param dto отправленные данные аккаунта
     * @param result результат валидации формы
     * @return форма администратора с ошибками или перенаправление в панель администратора
     */
    public String createAdmin(
            @Valid @ModelAttribute("user") UserRegistrationDto dto,
            BindingResult result) {
        if (userService.usernameExists(dto.getUsername())) {
            result.rejectValue("username", "username.exists", "Такой логин уже занят");
        }
        if (result.hasErrors()) {
            return "admin/admin-form";
        }
        userService.registerAdmin(dto);
        return "redirect:/admin";
    }
}
