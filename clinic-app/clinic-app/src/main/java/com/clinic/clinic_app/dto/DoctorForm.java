package com.clinic.clinic_app.dto;

import jakarta.validation.constraints.*;
import lombok.Data;

@Data
public class DoctorForm {

    @NotBlank(message = "Укажите ФИО врача")
    @Size(max = 120, message = "ФИО слишком длинное")
    private String fullName;

    @NotBlank(message = "Укажите специализацию")
    @Size(max = 80, message = "Специализация слишком длинная")
    private String specialization;

    @NotNull(message = "Укажите стаж")
    @Min(value = 0, message = "Стаж не может быть отрицательным")
    @Max(value = 70, message = "Стаж указан слишком большим")
    private Integer experienceYears;

    @NotBlank(message = "Укажите кабинет")
    @Size(max = 40, message = "Номер кабинета слишком длинный")
    private String office;

    private Boolean active = true;
}
