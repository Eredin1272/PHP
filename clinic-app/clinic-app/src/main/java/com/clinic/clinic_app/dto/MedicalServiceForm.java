package com.clinic.clinic_app.dto;

import jakarta.validation.constraints.*;
import lombok.Data;

import java.math.BigDecimal;

@Data
public class MedicalServiceForm {

    @NotBlank(message = "Укажите название услуги")
    @Size(max = 100, message = "Название услуги слишком длинное")
    private String name;

    @NotBlank(message = "Укажите описание услуги")
    @Size(min = 10, max = 1000, message = "Описание должно содержать от 10 до 1000 символов")
    private String description;

    @NotNull(message = "Укажите цену")
    @DecimalMin(value = "0.00", inclusive = false, message = "Цена должна быть больше нуля")
    private BigDecimal price;

    private Boolean active = true;
}
