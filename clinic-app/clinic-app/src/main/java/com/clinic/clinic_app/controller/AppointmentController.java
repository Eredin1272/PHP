package com.clinic.clinic_app.controller;

import com.clinic.clinic_app.dto.AppointmentForm;
import com.clinic.clinic_app.dto.AppointmentSearchForm;
import com.clinic.clinic_app.model.AppointmentStatus;
import com.clinic.clinic_app.service.AppointmentService;
import com.clinic.clinic_app.service.DoctorService;
import com.clinic.clinic_app.service.MedicalServiceService;
import jakarta.validation.Valid;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/appointments")
public class AppointmentController {

    private final AppointmentService appointmentService;
    private final DoctorService doctorService;
    private final MedicalServiceService medicalServiceService;

    public AppointmentController(
            AppointmentService appointmentService,
            DoctorService doctorService,
            MedicalServiceService medicalServiceService) {
        this.appointmentService = appointmentService;
        this.doctorService = doctorService;
        this.medicalServiceService = medicalServiceService;
    }

    @GetMapping("/new")
    /**
     * Отображает форму создания заявки на приём.
     *
     * @param model модель для передачи новой формы, списка врачей и списка услуг
     * @return страница создания заявки
     */
    public String newAppointment(Model model) {
        model.addAttribute("appointment", new AppointmentForm());
        addFormLists(model);
        return "appointments/new";
    }

    @PostMapping
    /**
     * Обрабатывает создание заявки на приём с серверной валидацией.
     *
     * @param form отправленная форма заявки
     * @param result результат валидации формы
     * @param model модель для повторной передачи списков врачей и услуг при ошибках
     * @return форма заявки с ошибками или перенаправление на страницу поиска записей
     */
    public String create(
            @Valid @ModelAttribute("appointment") AppointmentForm form,
            BindingResult result,
            Model model) {
        if (result.hasErrors()) {
            addFormLists(model);
            return "appointments/new";
        }

        appointmentService.create(form);
        return "redirect:/appointments/search?created";
    }

    @GetMapping("/search")
    /**
     * Отображает результаты поиска заявок на приём.
     *
     * @param form критерии поиска, полученные из параметров запроса
     * @param model модель для передачи результатов поиска, врачей и статусов
     * @return страница поиска записей
     */
    public String search(@ModelAttribute("search") AppointmentSearchForm form, Model model) {
        model.addAttribute("appointments", appointmentService.search(form));
        model.addAttribute("doctors", doctorService.findActive());
        model.addAttribute("statuses", AppointmentStatus.values());
        return "appointments/search";
    }

    private void addFormLists(Model model) {
        model.addAttribute("doctors", doctorService.findActive());
        model.addAttribute("services", medicalServiceService.findActive());
    }
}
