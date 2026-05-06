package com.clinic.clinic_app.dto;

import jakarta.validation.constraints.*;
import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDateTime;

@Data
public class AppointmentForm {

    @NotBlank(message = "Укажите ФИО пациента")
    @Size(min = 3, max = 120, message = "ФИО должно содержать от 3 до 120 символов")
    private String patientName;

    @NotBlank(message = "Укажите телефон")
    @Pattern(regexp = "^[0-9+()\\-\\s]{7,20}$", message = "Неверный формат телефона")
    private String phone;

    @NotBlank(message = "Укажите email")
    @Email(message = "Неверный формат email")
    private String email;

    @NotNull(message = "Выберите врача")
    private Long doctorId;

    @NotNull(message = "Выберите услугу")
    private Long medicalServiceId;

    @NotNull(message = "Выберите дату и время")
    @Future(message = "Дата и время должны быть в будущем")
    @DateTimeFormat(pattern = "yyyy-MM-dd'T'HH:mm")
    private LocalDateTime appointmentTime;

    @NotBlank(message = "Опишите жалобу")
    @Size(min = 10, max = 1000, message = "Описание должно содержать от 10 до 1000 символов")
    private String complaint;

    @AssertTrue(message = "Необходимо согласие на обработку данных")
    private boolean consent;
}
