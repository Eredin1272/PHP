package com.clinic.clinic_app;

import com.clinic.clinic_app.model.Announcement;
import com.clinic.clinic_app.model.Doctor;
import com.clinic.clinic_app.model.MedicalService;
import com.clinic.clinic_app.model.User;
import com.clinic.clinic_app.repository.AnnouncementRepository;
import com.clinic.clinic_app.repository.DoctorRepository;
import com.clinic.clinic_app.repository.MedicalServiceRepository;
import com.clinic.clinic_app.repository.UserRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

import java.math.BigDecimal;
import java.time.LocalDate;

@Component
public class DataInitializer implements CommandLineRunner {

    private final UserRepository userRepository;
    private final DoctorRepository doctorRepository;
    private final MedicalServiceRepository medicalServiceRepository;
    private final AnnouncementRepository announcementRepository;
    private final PasswordEncoder passwordEncoder;

    public DataInitializer(
            UserRepository userRepository,
            DoctorRepository doctorRepository,
            MedicalServiceRepository medicalServiceRepository,
            AnnouncementRepository announcementRepository,
            PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.doctorRepository = doctorRepository;
        this.medicalServiceRepository = medicalServiceRepository;
        this.announcementRepository = announcementRepository;
        this.passwordEncoder = passwordEncoder;
    }

    @Override
    public void run(String... args) {
        createDefaultAdmin();
        createPublicContent();
    }

    private void createDefaultAdmin() {
        if (userRepository.existsByUsername("admin")) {
            return;
        }

        User admin = new User();
        admin.setUsername("admin");
        admin.setPassword(passwordEncoder.encode("admin123"));
        admin.setRole("ROLE_ADMIN");
        userRepository.save(admin);
    }

    private void createPublicContent() {
        if (doctorRepository.count() == 0) {
            doctorRepository.save(new Doctor(null, "Анна Попеску", "Кардиология", 9, "201", true));
            doctorRepository.save(new Doctor(null, "Виктор Ионеску", "Неврология", 12, "305", true));
            doctorRepository.save(new Doctor(null, "Мария Русу", "Семейная медицина", 6, "104", true));
        }

        if (medicalServiceRepository.count() == 0) {
            medicalServiceRepository.save(new MedicalService(
                    null,
                    "Первичная консультация",
                    "Общая консультация врача с клиническими рекомендациями.",
                    new BigDecimal("250.00"),
                    true));
            medicalServiceRepository.save(new MedicalService(
                    null,
                    "Кардиологический осмотр",
                    "Оценка состояния сердца и составление плана лечения.",
                    new BigDecimal("400.00"),
                    true));
            medicalServiceRepository.save(new MedicalService(
                    null,
                    "Консультация невролога",
                    "Консультация при головных болях, головокружении и неврологических симптомах.",
                    new BigDecimal("380.00"),
                    true));
        }

        if (announcementRepository.count() == 0) {
            announcementRepository.save(new Announcement(
                    null,
                    "Доступна онлайн-запись",
                    "Пациенты могут отправить заявку и дождаться подтверждения администратора.",
                    LocalDate.now()));
            announcementRepository.save(new Announcement(
                    null,
                    "Расширен график кардиолога",
                    "Консультации кардиолога доступны по вечерам в будние дни.",
                    LocalDate.now().minusDays(1)));
            announcementRepository.save(new Announcement(
                    null,
                    "Профилактические осмотры",
                    "Клиника проводит профилактические консультации для взрослых и детей.",
                    LocalDate.now().minusDays(2)));
        }
    }
}
