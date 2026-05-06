package com.clinic.clinic_app.service;

import com.clinic.clinic_app.dto.UserRegistrationDto;
import com.clinic.clinic_app.model.User;
import com.clinic.clinic_app.repository.UserRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
public class UserService {

    private final UserRepository userRepository;
    private final PasswordEncoder passwordEncoder;

    public UserService(UserRepository userRepository, PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    /**
     * Регистрирует пользовательский аккаунт с хешированием пароля через BCrypt.
     *
     * @param dto проверенные данные формы регистрации
     * @return сохранённая сущность пользователя
     */
    public User registerUser(UserRegistrationDto dto) {
        return register(dto, "ROLE_USER");
    }

    /**
     * Регистрирует аккаунт администратора с хешированием пароля через BCrypt.
     *
     * @param dto проверенные данные формы регистрации
     * @return сохранённая сущность администратора
     */
    public User registerAdmin(UserRegistrationDto dto) {
        return register(dto, "ROLE_ADMIN");
    }

    /**
     * Проверяет, зарегистрирован ли уже указанный логин.
     *
     * @param username логин для проверки
     * @return true, если логин уже существует
     */
    public boolean usernameExists(String username) {
        return userRepository.existsByUsername(username);
    }

    private User register(UserRegistrationDto dto, String role) {
        if (usernameExists(dto.getUsername())) {
            throw new IllegalArgumentException("Username is already taken");
        }

        User user = new User();
        user.setUsername(dto.getUsername());
        user.setPassword(passwordEncoder.encode(dto.getPassword()));
        user.setRole(role);

        return userRepository.save(user);
    }
}
