package com.clinic.clinic_app.dto;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.Data;

@Data
public class UserRegistrationDto {

    @NotBlank(message = "Укажите логин")
    @Size(min = 3, max = 30, message = "Логин должен содержать от 3 до 30 символов")
    private String username;

    @NotBlank(message = "Укажите пароль")
    @Size(min = 6, max = 100, message = "Пароль должен содержать минимум 6 символов")
    private String password;
}
